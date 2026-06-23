<?php

require_once MODELS_PATH . 'App.model.php';

class MemberOtpModel extends AppModel
{
    public $primaryKey = 'id';
    public $table      = 'member_otp';

    public function insertOtp($member_id, $context, $code, $ip)
    {
        $pdo  = $this->getPdo();
        $stmt = $pdo->prepare(
            'INSERT INTO member_otp (member_id, context, otp_code, ip_address, expires_at)
             VALUES (?, ?, ?, ?, NOW() + INTERVAL 10 MINUTE)'
        );
        return $stmt->execute([$member_id, $context, $code, $ip]);
    }

    public function getLatestValid($member_id, $context)
    {
        $pdo  = $this->getPdo();
        $stmt = $pdo->prepare(
            'SELECT * FROM member_otp
             WHERE member_id = ? AND context = ? AND verified = 0 AND expires_at > NOW()
             ORDER BY created_at DESC LIMIT 1'
        );
        $stmt->execute([$member_id, $context]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function incrementAttempts($id)
    {
        $pdo  = $this->getPdo();
        $stmt = $pdo->prepare(
            'UPDATE member_otp SET attempts = attempts + 1 WHERE id = ?'
        );
        return $stmt->execute([$id]);
    }

    public function markVerified($id)
    {
        $pdo  = $this->getPdo();
        $stmt = $pdo->prepare(
            'UPDATE member_otp SET verified = 1, verified_at = NOW() WHERE id = ?'
        );
        return $stmt->execute([$id]);
    }

    public function forceExpire($id)
    {
        $pdo  = $this->getPdo();
        $stmt = $pdo->prepare(
            'UPDATE member_otp SET expires_at = NOW() WHERE id = ?'
        );
        return $stmt->execute([$id]);
    }

    public function cleanup()
    {
        $pdo  = $this->getPdo();
        $stmt = $pdo->prepare(
            'DELETE FROM member_otp WHERE expires_at < NOW() - INTERVAL 24 HOUR'
        );
        return $stmt->execute();
    }
}
