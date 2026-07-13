(function ($) {
    function getSafeResponseInput(res, id, jq) {
        var $jq = jq || (typeof gz$ !== 'undefined' ? gz$ : $);
        var nodes = $jq.parseHTML($jq.trim(res || ''), document, false) || [];
        var $nodes = $jq(nodes);
        var $el = $nodes.filter('input#' + id);
        if (!$el.length) {
            $el = $jq('<div>').append($nodes).find('input#' + id);
        }
        return $el;
    }

    $(function () {
        //debugger;
        var url = $("#container-abc-url-id").text();

        if ($('#MemberID').length > 0) {
            $('#MemberID').selectpicker();
        }

        $(document).delegate('#reset-btn-id', 'click', function (e) {
            $('#new_student')[0].reset();
        }).delegate('#directamount', 'change', function () {
            debugger;
            var directdepositamount = $("#directamount").val();
             var studentamount = $("#Amount").val();
           
            if( directdepositamount < studentamount ){
                alert('Student total fee price and direct deposit amount not same please select correct payment');
            $("#payment_btn_id").addClass('disabled');
            }
            else{
                $("#payment_btn_id").removeClass('disabled');
            }
        }).delegate('#cashamount', 'change', function () {
            debugger;
            var studentcash = $("#cashamount").val();
            var studentamount = $("#Amount").val();
    
            if( studentcash < studentamount){
                alert('Student total fee price and cash amount not same please select correct payment');
            $("#payment_btn_id").addClass('disabled');
            }
            else{
                $("#payment_btn_id").removeClass('disabled');
            }
        }).delegate('#checkamount', 'change', function () {
            debugger;
            var amountcheck = $("#checkamount").val();
            var studentamount = $("#Amount").val();
            if( amountcheck < studentamount ){
                alert('Student total fee price and check amount not same please select correct payment');
               $("#payment_btn_id").addClass('disabled');
            }
            else{
                $("#payment_btn_id").removeClass('disabled');
            }
        }).delegate('#registrationtype', 'change', function (event) {
            //debugger;
            var regtype = $("#registrationtype").val();
            document.getElementById("fee").value = "";
            document.getElementById("Amount").value = "";
            if (regtype == "workshops" || regtype == "library") {
                //$("#type").prop('readonly', true);
                $("#typecheck").prop('required', false);
                $("#type1").prop('required', false);
                document.getElementById('allsubject').style.display = 'none';
                $('#subjectrow').hide();
                //document.getElementById('type1').style.display = 'none';
            } else {
                document.getElementById('allsubject').style.removeProperty('display');
                $('#subjectrow').show();
                //document.getElementById('type1').style.removeProperty('display');
            }

            $.ajax({
                type: "POST",
                data: {
                    regtype: regtype
                },
                url: url + "load.php?controller=Student&action=subjectsstudent",
                success: function (res) {

                    //debugger;
                    $('#typecheck').empty(); //remove all child nodes
                    $('#type1').empty();  //remove all child nodes
                    var newOption = $(res);
                    var secondOption = $(res);
                    $('#typecheck').append(newOption);
                    $('#typecheck').trigger("chosen:updated");
                    $('#type1').append(secondOption);
                    $('#type1').trigger("chosen:updated");
                    $('#registrationmember').change();
                }
            });
        });
    }).delegate("#typecheck", "change", function (e) {
       // debugger;
        e.stopImmediatePropagation();
        var typemember = $("#registrationmember").val();
        var regtype = $("#registrationtype").val();
        var typec = $("#typecheck").val();
        var typec = $("#typecheck").val();
        let date =  new Date().getFullYear();
        let latefeedate= '31'+'/03/'+date;
        let currentdaydate = formatDate(new Date());
         if(typec == ""){
             document.getElementById("Amount").value = "";
           
         }
         if (regtype = "" || typemember == "") {
            alert("Please Select Registration Type/ Member Type First");
            return false;
         }
        //e.stopImmediatePropagation();
        var selected = [];
        for (var option of document.getElementById('typecheck').options) {
            if (option.selected) {
                selected.push(option.value);
            }
        }
        selcetsubj = selected;
        var retype = $("#registrationtype").val();
        var dd2 = $("#type1").val();
        if (retype == 'BanglaSchool') {
            if (selcetsubj.length > 1) {
                selcetsubj.splice(-1);
                $(this).val(last_valid_selection);
                alert("Please Select only one subject");
            } else {
                last_valid_selection = $(this).val();
            }
        }
        if (retype == 'Kalabhavan') {
            if (selcetsubj.length > 2) {
                selcetsubj.splice(-1);
                $(this).val(last_valid_selection);
                alert("Please Select only two subject");
            } else {
                last_valid_selection = $(this).val();
            }
        }
        var cat = $("#cattype").val();
        var price = $("#fee").val();
        if (dd2 == "") {

            var test =document.getElementById("typecheck").value;
            if (selcetsubj.length > 1 && dd2 == "") {
                var courceCount = selcetsubj.length;
                var amount = courceCount * price;
              if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 10;
                }
                // if(currentdaydate > latefeedate && retype == 'Kalabhavan'){ 

                //     var courceCount = selcetsubj.length;
                //     var totallatefee =  courceCount * 10;
                //     document.getElementById("Amount").value = totalprice + totallatefee;
                //  }
                //  else{
                    document.getElementById("Amount").value = totalprice;
                 //}

               // document.getElementById("Amount").value = totalprice;
              
            }
            else if (selcetsubj.length > 0 && dd2 == "") {
                var courceCount = selcetsubj.length;
                var amount = courceCount * price;
                var totalprice = amount;

                // if(currentdaydate > latefeedate && retype == 'Kalabhavan'){ 

                //     var courceCount = selcetsubj.length;
                //     var totallatefee =  courceCount * 10;
                //     document.getElementById("Amount").value = totalprice + totallatefee;
                //  }
                //  else{
                    document.getElementById("Amount").value = totalprice;
                // }
                //document.getElementById("Amount").value = totalprice;
             
            }
        } else {
            var newsubjectrec = selcetsubj.concat(subjectsecond);
            if (selcetsubj.length > 1 && subjectsecond.length == 0) {
                var courceCount = selcetsubj.length;
                var amount = courceCount * price;
               if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 10;
                }

                // if(currentdaydate > latefeedate && retype == 'Kalabhavan'){ 

                //     var courceCount = selcetsubj.length;
                //     var totallatefee =  courceCount * 10;
                //     document.getElementById("Amount").value = totalprice + totallatefee;
                //  }
                //  else{
                    document.getElementById("Amount").value = totalprice;
                 //}
                //document.getElementById("Amount").value = totalprice;
                
            }
            else if (selcetsubj.length > 0 && subjectsecond.length == 0) {
                var courceCount = selcetsubj.length;
                var amount = courceCount * price;
                var totalprice = amount;

                // if(currentdaydate > latefeedate && retype == 'Kalabhavan'){ 

                //     var courceCount = selcetsubj.length;
                //     var totallatefee =  courceCount * 10;
                //     document.getElementById("Amount").value = totalprice + totallatefee;
                //  }
                //  else{
                    document.getElementById("Amount").value = totalprice;
                 //}
                //document.getElementById("Amount").value = totalprice;
              
            }
            else if (newsubjectrec.length > 3) {
                var courceCount = newsubjectrec.length;
                var amount = courceCount * price;
               if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 20;
                }
                // if(currentdaydate > latefeedate && retype == 'Kalabhavan'){ 

                //     var courceCount = newsubjectrec.length;
                //     var totallatefee =  courceCount * 10;
                //     document.getElementById("Amount").value = totalprice + totallatefee;
                //  }
                //  else{
                    document.getElementById("Amount").value = totalprice;
                 //}
                //document.getElementById("Amount").value = totalprice;
               

            }
            else if (newsubjectrec.length > 2) {
                var courceCount = newsubjectrec.length;
                var amount = courceCount * price;
                if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 10;
                }
                // if(currentdaydate > latefeedate && retype == 'Kalabhavan'){ 

                //     var courceCount = newsubjectrec.length;
                //     var totallatefee =  courceCount * 10;
                //     document.getElementById("Amount").value = totalprice + totallatefee;
                //  }
                //  else{
                    document.getElementById("Amount").value = totalprice;
                 //}
                //document.getElementById("Amount").value = totalprice;
             
            }
            else if (selcetsubj.length > 0 && subjectsecond.length > 0) {
                var totalsub = selcetsubj.concat(subjectsecond);
                var courceCount = totalsub.length
                var amount = courceCount * price;
                if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 10;
                }

                // if(currentdaydate > latefeedate && retype == 'Kalabhavan'){ 

                //     var courceCount = totalsub.length;
                //     var totallatefee =  courceCount * 10;
                //     document.getElementById("Amount").value = totalprice + totallatefee;
                //  }
                //  else{
                    document.getElementById("Amount").value = totalprice;
                 //}
                //document.getElementById("Amount").value = totalprice;
              
            }
        }

    }).delegate("#typecheck", "click", function (e) {
       // debugger;
        e.stopImmediatePropagation();
        var typemember = $("#registrationmember").val();
        var regtype = $("#registrationtype").val();
        var typec = $("#typecheck").val();
        let date =  new Date().getFullYear();
        let latefeedate= '31'+'/03/'+date;
        let currentdaydate = formatDate(new Date());
         if(typec == ""){
             document.getElementById("Amount").value = "";
           
         }
         if (regtype = "" || typemember == "") {
            alert("Please Select Registration Type/ Member Type First");
            return false;
         }
        //e.stopImmediatePropagation();
        var selected = [];
        for (var option of document.getElementById('typecheck').options) {
            if (option.selected) {
                selected.push(option.value);
            }
        }
        selcetsubj = selected;
        var retype = $("#registrationtype").val();
        var dd2 = $("#type1").val();
        if (retype == 'BanglaSchool') {
            if (selcetsubj.length > 1) {
                selcetsubj.splice(-1);
                $(this).val(last_valid_selection);
                alert("Please Select only one subject");
            } else {
                last_valid_selection = $(this).val();
            }
        }
        if (retype == 'Kalabhavan') {
            if (selcetsubj.length > 2) {
                selcetsubj.splice(-1);
                $(this).val(last_valid_selection);
                alert("Please Select only two subject");
            } else {
                last_valid_selection = $(this).val();
            }
        }
        var cat = $("#cattype").val();
        var price = $("#fee").val();
        if (dd2 == "") {

            var test =document.getElementById("typecheck").value;
            if (selcetsubj.length > 1 && dd2 == "") {
                var courceCount = selcetsubj.length;
                var amount = courceCount * price;
              if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 10;
                }
                // if(currentdaydate > latefeedate && retype == 'Kalabhavan'){ 

                //     var courceCount = selcetsubj.length;
                //     var totallatefee =  courceCount * 10;
                //     document.getElementById("Amount").value = totalprice + totallatefee;
                //  }
                //  else{
                    document.getElementById("Amount").value = totalprice;
                 //}


                //document.getElementById("Amount").value = totalprice;
              
            }
            else if (selcetsubj.length > 0 && dd2 == "") {
                var courceCount = selcetsubj.length;
                var amount = courceCount * price;
                var totalprice = amount;
                // if(currentdaydate > latefeedate && retype == 'Kalabhavan'){ 

                //     var courceCount = selcetsubj.length;
                //     var totallatefee =  courceCount * 10;
                //     document.getElementById("Amount").value = totalprice + totallatefee;
                //  }
                //  else{
                    document.getElementById("Amount").value = totalprice;
                 //}
               //document.getElementById("Amount").value = totalprice;
             
            }
        } else {
            var newsubjectrec = selcetsubj.concat(subjectsecond);
            if (selcetsubj.length > 1 && subjectsecond.length == 0) {
                var courceCount = selcetsubj.length;
                var amount = courceCount * price;
               if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 10;
                }

                // if(currentdaydate > latefeedate && retype == 'Kalabhavan'){ 

                //     var courceCount = selcetsubj.length;
                //     var totallatefee =  courceCount * 10;
                //     document.getElementById("Amount").value = totalprice + totallatefee;
                //  }
                //  else{
                    document.getElementById("Amount").value = totalprice;
                // }
                //document.getElementById("Amount").value = totalprice;
                
            }
            else if (selcetsubj.length > 0 && subjectsecond.length == 0) {
                var courceCount = selcetsubj.length;
                var amount = courceCount * price;
                var totalprice = amount;

                // if(currentdaydate > latefeedate && retype == 'Kalabhavan'){ 

                //     var courceCount = selcetsubj.length;
                //     var totallatefee =  courceCount * 10;
                //     document.getElementById("Amount").value = totalprice + totallatefee;
                //  }
                //  else{
                    document.getElementById("Amount").value = totalprice;
                 //}
                //document.getElementById("Amount").value = totalprice;
              
            }
            else if (newsubjectrec.length > 3) {
                var courceCount = newsubjectrec.length;
                var amount = courceCount * price;
               if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 20;
                }
                // if(currentdaydate > latefeedate && retype == 'Kalabhavan'){ 

                //     var courceCount = newsubjectrec.length;
                //     var totallatefee =  courceCount * 10;
                //     document.getElementById("Amount").value = totalprice + totallatefee;
                //  }
                //  else{
                    document.getElementById("Amount").value = totalprice;
                 //}
                //document.getElementById("Amount").value = totalprice;
               

            }
            else if (newsubjectrec.length > 2) {
                var courceCount = newsubjectrec.length;
                var amount = courceCount * price;
                if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 10;
                }
                // if(currentdaydate > latefeedate && retype == 'Kalabhavan'){ 

                //     var courceCount = newsubjectrec.length;
                //     var totallatefee =  courceCount * 10;
                //     document.getElementById("Amount").value = totalprice + totallatefee;
                //  }
                //  else{
                    document.getElementById("Amount").value = totalprice;
                 //}
                //document.getElementById("Amount").value = totalprice;
             
            }
            else if (selcetsubj.length > 0 && subjectsecond.length > 0) {
                var totalsub = selcetsubj.concat(subjectsecond);
                var courceCount = totalsub.length
                var amount = courceCount * price;
                if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 10;
                }
                // if(currentdaydate > latefeedate && retype == 'Kalabhavan'){ 

                //     var courceCount = totalsub.length;
                //     var totallatefee =  courceCount * 10;
                //     document.getElementById("Amount").value = totalprice + totallatefee;
                //  }
                //  else{
                    document.getElementById("Amount").value = totalprice;
                 //}
                //document.getElementById("Amount").value = totalprice;
              
             }
        }

}).delegate("#SecondStudentName", "keyup", function (e) {
           e.stopImmediatePropagation();

         var stu2 = $("#SecondStudentName").val();
        //  var schoolregisternew = $("#registrationtype").val();
        //  if (schoolregisternew == "Kalabhavan" || schoolregisternew == "BanglaSchool") {
        //     if (studentFirst != "" && studentSecond == "") {
        //         document.getElementById("type1").value = "";
        //     }}
        let date =  new Date().getFullYear();
        let latefeedate= '31'+'/03/'+date;
        let currentdaydate = formatDate(new Date());
         var first = $("#FirstStudentName").val();
        if(first == "" || first == null){
            alert("Please fill First Student Name first");
            $("#SecondStudentName").val('');
            return;
        }
        
        if ($(this).val().length != 0) {
            //debugger;
            $('#type1').attr('disabled', false);
            var schoolregister = $("#registrationtype").val();
            var amountfee = $("#fee").val();
            var studentSecond = $("#SecondStudentName").val();
            var studentFirst = $("#FirstStudentName").val();

            
            if (schoolregister == "workshops" || schoolregister == "library") {
                if (studentFirst.trim() != "" && studentSecond.trim() != "") {

                    var tot = amountfee;
                    var amount = tot * 2;
                    var totalprice = amount;
                    document.getElementById("Amount").value = totalprice;
                    
                }
                
                 e.stopImmediatePropagation();
                
            }
            

        }
        else {
          
            $('#type1').attr('disabled', true);
            var schoolregistercheck = $("#registrationtype").val();
            var stu1 = $("#FirstStudentName").val();
            var stu2 = $("#SecondStudentName").val();
            var getvalueseconddubject = $("#type1").val();
            var getvaluefirstdubject = $("#typecheck").val();
            var amountfeenew = parseInt($("#fee").val()); 
             var cat = $("#cattype").val();
            if (schoolregistercheck == "BanglaSchool"){
                if((stu1.trim() !="") && (stu2.trim() =="")){
                    document.getElementById("type1").value = "";
                    // if(currentdaydate < latefeedate){ 

                    //     document.getElementById("Amount").value = amountfeenew + 10;
                    //  }
                    //  else{
                    //     document.getElementById("Amount").value = amountfeenew;
                    //  }
                    document.getElementById("Amount").value = amountfeenew;  
                }
                
              }

              if (schoolregistercheck == "Kalabhavan"){
                if((stu2.trim() =="")){
                    document.getElementById("type1").value = "";
                    var len = getvaluefirstdubject.length;
                    if(len == 2){
                    var getvaluefirstdubject = amountfeenew * 2
                   if(cat=="GD" || cat=="GC"){
                     var discountprice =  getvaluefirstdubject;
                    }else{
                    var discountprice =  getvaluefirstdubject - 10;
                    }
                    document.getElementById("Amount").value = discountprice;    
                    }else{
                      //document.getElementById("Amount").value = amountfeenew;  
                    }
                    
                }
              }
         if (schoolregistercheck == "workshops" || schoolregistercheck == "library"){
            if(stu1!=""){
                document.getElementById("Amount").value = amountfeenew;

            }
         }
        }
    }).delegate("#SecondStudentName", "click", function (e) {
       //debugger
       var amountfee = $("#fee").val();
        e.stopImmediatePropagation();
         var stu2 = $("#SecondStudentName").val();
        //  if(stu2==""){
        //      document.getElementById("Amount").value = "";
        //       // $("#FirstStudentName").val("");
        //  }
        // var schoolregisternew = $("#registrationtype").val();
        // if (schoolregisternew == "Kalabhavan" || schoolregisternew == "BanglaSchool") {
        //    if (studentFirst != "" && studentSecond == "") {
        //        document.getElementById("type1").value = "";
        //    }}
        let date =  new Date().getFullYear();
        let latefeedate= '31'+'/03/'+date;
        let currentdaydate = formatDate(new Date());

        if ($(this).val().length != 0) {
            //debugger;
            $('#type1').attr('disabled', false);
            var schoolregister = $("#registrationtype").val();
            var amountfee = parseInt($("#fee").val());
            var studentSecond = $("#SecondStudentName").val();
            var studentFirst = $("#FirstStudentName").val();


            if (schoolregister == "workshops" || schoolregister == "library") {
                if (studentFirst.trim() != "" && studentSecond.trim() != "") {

                    var tot = amountfee;
                    var amount = tot * 2;
                    var totalprice = amount;
                    document.getElementById("Amount").value = totalprice;
                }
                
                    
                
            }

        }
        else {
            $('#type1').attr('disabled', true);
            var stu1 = $("#FirstStudentName").val();
            var stu2 = $("#SecondStudentName").val();
            var schoolregistercheck = $("#registrationtype").val();
            var amountfeenew = parseInt($("#fee").val());
            var getvalueseconddubject = $("#type1").val();
            var getvaluefirstdubject = $("#typecheck").val();
             var cat = $("#cattype").val();
            if (schoolregistercheck == "BanglaSchool"){
                if((stu1.trim() !="") && (stu2.trim() =="")){
                    document.getElementById("type1").value = "";
                    document.getElementById("Amount").value = amountfeenew;  
                }
              }

              if (schoolregistercheck == "Kalabhavan"){
                if((stu2.trim() =="")){
                    document.getElementById("type1").value = "";
                    var len = getvaluefirstdubject.length;
                    if(len == 2){
                    var getvaluefirstdubject = amountfeenew * 2
                   if(cat=="GD" || cat=="GC"){
                     var discountprice =  getvaluefirstdubject;
                    }else{
                    var discountprice =  getvaluefirstdubject - 10;
                    }
                    //document.getElementById("Amount").value = discountprice; 
                    // if(currentdaydate > latefeedate){ 

                    //     var courceCount = getvaluefirstdubject.length;
                    //     var totallatefee =  courceCount * 10;
                    //     document.getElementById("Amount").value = discountprice + totallatefee;
                    //  }
                    //  else{
                        document.getElementById("Amount").value = discountprice;
                    //}   
                    }else{
                        // if(currentdaydate > latefeedate){ 
                        //     var courceCount = getvaluefirstdubject.length;
                        //     var totallatefee =  courceCount * 10;
                        //     document.getElementById("Amount").value = amountfeenew + totallatefee;
                        //  }
                        //  else{
                            document.getElementById("Amount").value = amountfeenew;
                         //} 
                       // document.getElementById("Amount").value = amountfeenew;  
                    }
                    
                }
              }
             if (schoolregistercheck == "workshops" || schoolregistercheck == "library"){
                //debugger;
                if(stu1.trim() !=""){
                    document.getElementById("Amount").value = amountfeenew;
                }
             }
        }
        e.preventDefault();
    }).delegate("#SecondStudentName", "change", function (e) {
        //debugger;
       var stu2 = $("#SecondStudentName").val();
       var amountfee = $("#fee").val();
       let date =  new Date().getFullYear();
       let latefeedate= '31'+'/03/'+date;
       let currentdaydate = formatDate(new Date());
        e.stopImmediatePropagation();
        var first = $("#FirstStudentName").val();
       

        //if (first.trim() = "") {
        //   alert("Please fill first student name.");
        //}
        var fname = first.replace(/^\s+|\s+$/gm,'');
        if (fname= "") {
           alert("Please fill first student name.");
        }
        
        
        

        if ($(this).val().length != 0) {
            //debugger;
            $('#type1').attr('disabled', false);
            var schoolregister = $("#registrationtype").val();
            var amountfee = parseInt($("#fee").val());
            var studentSecond = $("#SecondStudentName").val();
            var studentFirst = $("#FirstStudentName").val();

            var second = $("#SecondStudentName").val();
            if (second.trim() == "") {

                document.getElementById("Amount").value = "";

            }
            if (schoolregister == "workshops" || schoolregister == "library") {
                if (studentFirst.trim() != "" && studentSecond.trim() != "") {

                    var tot = amountfee;
                    var amount = tot * 2;
                    var totalprice = amount;
                    document.getElementById("Amount").value = totalprice;
                }
                
                
            }

        }
        else {
           // debugger;
            $('#type1').attr('disabled', true);
            var stu1 = $("#FirstStudentName").val();
            var stu2 = $("#SecondStudentName").val();
            var schoolregistercheck = $("#registrationtype").val();
            var amountfeenew = parseInt($("#fee").val());
            var getvalueseconddubject = $("#type1").val();
            var getvaluefirstdubject = $("#typecheck").val();
             var cat = $("#cattype").val();
            if (schoolregistercheck == "BanglaSchool"){
                if((stu1.trim() !="") && (stu2.trim() =="")){
                    document.getElementById("type1").value = "";
                    document.getElementById("Amount").value = amountfeenew;  
                }
              }

              if (schoolregistercheck == "Kalabhavan"){
                //debugger;
                if((stu2.trim() =="")){
                    document.getElementById("type1").value = "";
                    var len = getvaluefirstdubject.length;
                    if(len == 2){
                    var getvaluefirstdubject = amountfeenew * 2
                     if(cat=="GD" || cat=="GC"){
                     var discountprice =  getvaluefirstdubject;
                    }else{
                    var discountprice =  getvaluefirstdubject - 10;
                    }
                   
                    //document.getElementById("Amount").value = discountprice;  
                    // if(currentdaydate > latefeedate){ 

                    //     var courceCount = getvaluefirstdubject.length;
                    //     var totallatefee =  courceCount * 10;
                    //     document.getElementById("Amount").value = discountprice + totallatefee;
                    //  }
                    //  else{
                        document.getElementById("Amount").value = discountprice;
                     //}
                    }else{
                       // document.getElementById("Amount").value = amountfeenew;  
                    //    if(currentdaydate > latefeedate){ 
                    //     var courceCount = getvaluefirstdubject.length;
                    //     var totallatefee =  courceCount * 10;
                    //     document.getElementById("Amount").value = amountfeenew + totallatefee;
                    //  }
                    //  else{
                        document.getElementById("Amount").value = amountfeenew;
                     //}
                    }
                    
                }
              }
             if (schoolregistercheck == "workshops" || schoolregistercheck == "library"){
                //debugger;
                if(stu1.trim() !=""){
                    document.getElementById("Amount").value = amountfeenew;
                }
             }
        }
        e.preventDefault();
    }).delegate("#FirstStudentName", "click", function (e) {
        e.preventDefault();
        var schoolregister = $("#registrationtype").val();
        var amountfee = $("#fee").val();
        var studentSecond = $("#SecondStudentName").val();
        var studentFirst = $("#FirstStudentName").val();



        if ((schoolregister == "workshops" || schoolregister == "library")) {
            if (studentFirst.trim() != "" && studentSecond.trim() == "") {
                document.getElementById("Amount").value = amountfee;
            }
        }
        e.preventDefault();
    }).delegate("#FirstStudentName", "change", function (e) {
        e.stopImmediatePropagation();
        var stu1 = $("#FirstStudentName").val();
         if(stu1.trim() ==""){
             document.getElementById("Amount").value = "";
             document.getElementById("SecondStudentName").value = "";
             document.getElementById("type1").value = "";
             document.getElementById("typecheck").value = "";
         }
        //debugger;
        var regtype = $("#registrationtype").val();
        var typemember = $("#registrationmember").val();
        if (regtype.trim() == "" || typemember.trim() == "") {
            alert("Please Select Registration Type/ Member Type First");
            return false;

        } else {

            var schoolregister = $("#registrationtype").val();
            var amountfee = $("#fee").val();
            var studentSecond = $("#SecondStudentName").val();
            var studentFirst = $("#FirstStudentName").val();



            if ((schoolregister == "workshops" || schoolregister == "library")) {
                if (studentFirst.trim() != "" && studentSecond.trim() == "") {
                    document.getElementById("Amount").value = amountfee;
                }
            }
        }
        e.preventDefault();
       
    }).delegate("#type1", "change", function (e) {
       
        var typemember = $("#registrationmember").val();
         var type = $("#type1").val();
         let date =  new Date().getFullYear();
         let latefeedate= '31'+'/03/'+date;
         let currentdaydate = formatDate(new Date());
         if(type==""){
             document.getElementById("Amount").value = "";
         }
 

        var selected1 = [];
        for (var option of document.getElementById('type1').options) {
            if (option.selected) {
                selected1.push(option.value);
            }
        }
        subjectsecond = selected1;
 //alert(subjectsecond);
 // alert(selected1);
        var retype = $("#registrationtype").val();
        //debugger;
        if (retype == 'BanglaSchool') {
              
            if (subjectsecond.length > 1) {
               
                subjectsecond.splice(-1);
                $(this).val(last_valid_selection);
                alert("Please Select only one subject");
            } else {
                last_valid_selection = $(this).val();
            }
        }
        if (retype == 'Kalabhavan') {
            
            if (subjectsecond.length > 2) {
                 
                subjectsecond.splice(-1);
                $(this).val(last_valid_selection);
                alert("Please Select only two subject");
            } else {
                last_valid_selection = $(this).val();
            }
        }

        //debugger;
        var newsubjectrec = selcetsubj.concat(subjectsecond);
        var price = $("#fee").val();
        var cat = $("#cattype").val();
        if (selcetsubj.length > 1 && subjectsecond.length == 0) {
            var courceCount = selcetsubj.length;
            var amount = courceCount * price;
           if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 10;
                }
                let date =  new Date().getFullYear();
                let latefeedate= '31'+'/03/'+date;
                let currentdaydate = formatDate(new Date());
                // if(currentdaydate > latefeedate && retype == 'Kalabhavan'){ 
                //     var courceCount = selcetsubj.length;
                //     var totallatefee =  courceCount * 10;
                //     document.getElementById("Amount").value = totalprice + totallatefee;
                //  }
                //  else{
                    document.getElementById("Amount").value = totalprice;
                 //}
            //document.getElementById("Amount").value = totalprice;
            
        }
        else if (selcetsubj.length > 0 && subjectsecond.length == 0) {
            var courceCount = selcetsubj.length;
            var amount = courceCount * price;
            var totalprice = amount;

            let date =  new Date().getFullYear();
            let latefeedate= '31'+'/03/'+date;
            let currentdaydate = formatDate(new Date());
            // if(currentdaydate > latefeedate && retype == 'Kalabhavan'){ 
            //     var courceCount = selcetsubj.length;
            //     var totallatefee =  courceCount * 10;
            //     document.getElementById("Amount").value = totalprice + totallatefee;
            //  }
            //  else{
                document.getElementById("Amount").value = totalprice;
             //}
           // document.getElementById("Amount").value = totalprice;
           
        }
        else if (newsubjectrec.length > 3) {
            var courceCount = newsubjectrec.length;
            var amount = courceCount * price;
           if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 20;
                }
                let date =  new Date().getFullYear();
                let latefeedate= '31'+'/03/'+date;
                let currentdaydate = formatDate(new Date());
                // if(currentdaydate > latefeedate && retype == 'Kalabhavan'){ 
                //     var courceCount = newsubjectrec.length;
                //     var totallatefee =  courceCount * 10;
                //     document.getElementById("Amount").value = totalprice + totallatefee;
                //  }
                //  else{
                    document.getElementById("Amount").value = totalprice;
                 //}
           // document.getElementById("Amount").value = totalprice;
         

        }
        else if (newsubjectrec.length > 2) {
            var courceCount = newsubjectrec.length;
            var amount = courceCount * price;
            if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 10;
                }
                let date =  new Date().getFullYear();
                let latefeedate= '31'+'/03/'+date;
                let currentdaydate = formatDate(new Date());
                // if(currentdaydate > latefeedate && retype == 'Kalabhavan'){ 
                //     var courceCount = newsubjectrec.length;
                //     var totallatefee =  courceCount * 10;
                //     document.getElementById("Amount").value = totalprice + totallatefee;
                //  }
                //  else{
                    document.getElementById("Amount").value = totalprice;
                 //}
            //document.getElementById("Amount").value = totalprice;
        
        }
        else if (selcetsubj.length > 0 && subjectsecond.length > 0) {
            var totalsub = selcetsubj.concat(subjectsecond);
            var courceCount = totalsub.length
            var amount = courceCount * price;
            if(cat=="GD" || cat=="GC"){
                var totalprice = amount;
            }else{
                var totalprice = amount - 10;
            }
            let date =  new Date().getFullYear();
                let latefeedate= '31'+'/03/'+date;
                let currentdaydate = formatDate(new Date());
            //     if(currentdaydate > latefeedate && retype == 'Kalabhavan'){ 
            //         var courceCount = totalsub.length;
            //         var totallatefee =  courceCount * 10;
            //         document.getElementById("Amount").value = totalprice + totallatefee;
            //      }
            //  else{
                document.getElementById("Amount").value = totalprice;
             //}
           // document.getElementById("Amount").value = totalprice;
          
        }


    }).delegate("#type1", "click", function (e) {
       
        var typemember = $("#registrationmember").val();
         var type = $("#type1").val();
         let date =  new Date().getFullYear();
         let latefeedate= '31'+'/03/'+date;
         let currentdaydate = formatDate(new Date());
         if(type==""){
             document.getElementById("Amount").value = "";
         }
 

        var selected1 = [];
        for (var option of document.getElementById('type1').options) {
            if (option.selected) {
                selected1.push(option.value);
            }
        }
        subjectsecond = selected1;
 //alert(subjectsecond);
 // alert(selected1);
        var retype = $("#registrationtype").val();
        //debugger;
        if (retype == 'BanglaSchool') {
              
            if (subjectsecond.length > 1) {
               
                subjectsecond.splice(-1);
                $(this).val(last_valid_selection);
                alert("Please Select only one subject");
            } else {
                last_valid_selection = $(this).val();
            }
        }
        if (retype == 'Kalabhavan') {
            
            if (subjectsecond.length > 2) {
                 
                subjectsecond.splice(-1);
                $(this).val(last_valid_selection);
                alert("Please Select only two subject");
            } else {
                last_valid_selection = $(this).val();
            }
        }

        //debugger;
        var newsubjectrec = selcetsubj.concat(subjectsecond);
        var price = $("#fee").val();
        var cat = $("#cattype").val();
        if (selcetsubj.length > 1 && subjectsecond.length == 0) {
            var courceCount = selcetsubj.length;
            var amount = courceCount * price;
           if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 10;
                }
                // if(currentdaydate > latefeedate && retype == 'Kalabhavan'){ 
                //     var courceCount = selcetsubj.length;
                //     var totallatefee =  courceCount * 10;
                //     document.getElementById("Amount").value = totalprice + totallatefee;
                //  }
                //  else{
                    document.getElementById("Amount").value = totalprice;
                 //}
           // document.getElementById("Amount").value = totalprice;
            
        }
        else if (selcetsubj.length > 0 && subjectsecond.length == 0) {
            var courceCount = selcetsubj.length;
            var amount = courceCount * price;
            var totalprice = amount;
            // if(currentdaydate > latefeedate && retype == 'Kalabhavan'){ 

            //     document.getElementById("Amount").value = totalprice + 10;
            //  }
            //  else{
                document.getElementById("Amount").value = totalprice;
             //}
            //document.getElementById("Amount").value = totalprice;
           
        }
        else if (newsubjectrec.length > 3) {
            var courceCount = newsubjectrec.length;
            var amount = courceCount * price;
           if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 20;
                }
                // if(currentdaydate > latefeedate && retype == 'Kalabhavan'){ 
                //     var courceCount = newsubjectrec.length;
                //     var totallatefee =  courceCount * 10;
                //     document.getElementById("Amount").value = totalprice + totallatefee;
                //  }
                //  else{
                    document.getElementById("Amount").value = totalprice;
                 //}
            //document.getElementById("Amount").value = totalprice;
         

        }
        else if (newsubjectrec.length > 2) {
            var courceCount = newsubjectrec.length;
            var amount = courceCount * price;
            if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 10;
                }
                // if(currentdaydate > latefeedate && retype == 'Kalabhavan'){ 
                //     var courceCount = newsubjectrec.length;
                //     var totallatefee =  courceCount * 10;
                //     document.getElementById("Amount").value = totalprice + totallatefee;
                //  }
                //  else{
                    document.getElementById("Amount").value = totalprice;
                 //}
           // document.getElementById("Amount").value = totalprice;
        
        }
        else if (selcetsubj.length > 0 && subjectsecond.length > 0) {
            var totalsub = selcetsubj.concat(subjectsecond);
            var courceCount = totalsub.length
            var amount = courceCount * price;
            if(cat=="GD" || cat=="GC"){
                var totalprice = amount;
            }else{
                var totalprice = amount - 10;
            }
            // if(currentdaydate > latefeedate && retype == 'Kalabhavan'){ 
            //     var courceCount = totalsub.length;
            //     var totallatefee =  courceCount * 10;
            //     document.getElementById("Amount").value = totalprice + totallatefee;
            //  }
            //  else{
                document.getElementById("Amount").value = totalprice;
             //}
            //document.getElementById("Amount").value = totalprice;
          
        }


    }).delegate('#registrationmember', 'change', function (event) {
        debugger;
        //var regmember = $("#registrationmember").val();
        var typeregistration = $("#registrationtype").val();
         var schoolregister = $("#registrationtype").val();
        if (schoolregister == "workshops" || schoolregister == "library") {
            $("#SecondStudentName").val('');
            $("#FirstStudentName").val('');
        }
        selectVal = $('#registrationmember').val();
        if (selectVal == "member") {
            $("#IDMembertd").removeClass("disabledbutton");
            document.getElementById("Amount").value = "";
             document.getElementById("FirstStudentName").value = "";
             document.getElementById("SecondStudentName").value = "";
            document.getElementById("type1").value = "";
            document.getElementById("typecheck").value = "";
            document.getElementById("namenonmember").value = "";
            document.getElementById("demmember").value = "";
            document.getElementById("Your_E-mail").value = "";
            document.getElementById("Your_Number").value = "";
            document.getElementById("term").value = "";
            document.getElementById("termMember").value = "";
             document.getElementById("cattype").value = "";
            $('#nonmembername').hide();
            $('#fieldtest').hide();
            $('#namemeemberregister').show();
            $('#IDMembertd').show();
            $("#namenonmember").prop('required',false);
             $("#term").prop('required',true);
          
        }
      //FirstStudentName
        if (selectVal == "nonmember") {
            $("#IDMembertd").addClass("disabledbutton");
            document.getElementById("Amount").value = "";
             document.getElementById("FirstStudentName").value = "";
             document.getElementById("SecondStudentName").value = "";
            document.getElementById("type1").value = "";
            document.getElementById("typecheck").value = "";
            document.getElementById("namenonmember").value = "";
            document.getElementById("demmember").value = "";
            document.getElementById("Your_E-mail").value = "";
            document.getElementById("Your_Number").value = "";
            document.getElementById("term").value = "";
            document.getElementById("termMember").value = "";
              document.getElementById("cattype").value = "";
            //$('#IDMembertd').find(':input').prop("disabled", true);
             $('#namemeemberregister').hide();
            $('#IDMembertd').hide();
            $('#nonmembername').show();
            $('#fieldtest').show();
            $("#fieldtest").prop('readonly',true);
            $("#namenonmember").prop('required',true);
            $("#term").prop('required',false);
           
        }
        if (selectVal.trim() == "" ) {
            $("#IDMembertd").removeClass("disabledbutton");
            document.getElementById("Amount").value = "";
            document.getElementById("type1").value = "";
            document.getElementById("typecheck").value = "";
            document.getElementById("namenonmember").value = "";
            document.getElementById("demmember").value = "";
            document.getElementById("Your_E-mail").value = "";
            document.getElementById("Your_Number").value = "";
            document.getElementById("term").value = "";
            document.getElementById("termMember").value = ""; 
              document.getElementById("cattype").value = "";
            document.getElementById("FirstStudentName").value = "";
            document.getElementById("SecondStudentName").value = "";
          
        }
       
        $.blockUI();
        // $.LoadingOverlay("show");
        var url = $("#container-abc-url-id").text();
        $.ajax({
            type: "POST",
            data: {
                regmember: selectVal,
                typeregistration: typeregistration,
            },
            url: url + "load.php?controller=Student&action=feeprice&cid=regmember",
            success: function (res) {
                //  $.LoadingOverlay("hide");
                $.unblockUI();
                //debugger;
                $('#fee').empty(); //remove all child nodes
                var feenewOption = $(res);
                $('#fee').append(feenewOption);
                $('#fee').trigger("chosen:updated");
                $('#FirstStudentName').click();
                $('#SecondStudentName').click();
            }
        });
    }).delegate('#IDMember22', 'change', function (event) {
        //debugger; 
        var Memberid = $("#IDMember22").val();
        var url = $("#container-abc-url-id").text();
        if ((Memberid != "GD") && (Memberid != "")) {
            $.ajax({
                type: "POST",
                data: {
                    memberid: Memberid
                },
                //url: url  +"load.php?controller=Member&action=AllMember",
                url: url + "load.php?controller=Student&action=AllMember",
                success: function (res) {
                    //debugger;
                    let memberid = "";
                    const memberElement = getSafeResponseInput(res, "memberid", $);
                    if (memberElement.length) {
                        memberid = memberElement[0].value;
                    }
                    document.getElementById("demmember").value = memberid;


                    let phoneNo = "";
                    const phoneNoElement = getSafeResponseInput(res, "Tele1", $);
                    if (phoneNoElement.length) {
                        phoneNo = phoneNoElement[0].value;
                    }
                    document.getElementById("Your_Number").value = phoneNo;

                    let email = "";
                    const emailElement = getSafeResponseInput(res, "email", $);
                    if (emailElement.length) {
                        email = emailElement[0].value;
                    }
                    document.getElementById("Your_E-mail").value = email;

                }
            });
        } else {
            $("#MemberName").val("");
            $("#phone").val("");
            $("#email").val("");

        }
    });
    function padTo2Digits(num) {
        return num.toString().padStart(2, '0');
      }
      
      function formatDate(date) {
        return [
          padTo2Digits(date.getDate()),
          padTo2Digits(date.getMonth() + 1),
          date.getFullYear(),
        ].join('/');
      }
	
}(jQuery));
