$(document).ready(function(){
    $('.focusedInput').focus();
    $(".userdetails").hide();
    var checkout = 0;
var idarr=[$('#fname'),$('#lname'),$('#phone'),$('#email'),$('#address1'),$('#city'),$('#state'),$('#zip'),
           $('#sfname'),$('#slname'),$('#sphone'),$('#semail'),$('#saddress1'),$('#scity'),$('#sstate'),$('#szip'),
		   $('#cnum1'),$('#mm'),$('#yy')];
var zipid = [$('#zip'),$('#szip')];
var phone = [$('#phone'),$('#sphone')];
var email = [$('#email'),$('#semail')];
var city = [$('#city'),$('#scity')];
var state =  [$('#state'),$('#sstate')];
var sendtitle = "";
var sendauth = "";
var aspectratio = "no";


    $('#sortorder').val(readCookie("SORT"));
    if(readCookie("AZTEKA") != null){
        $('#form-contain').hide();
        $('#lastaccess').show();
    }
    else
    {
         $('#form-contain').show();
         $('#lastaccess').hide();
    }
    
    var regexisbn = /^(?:ISBN(?:-1[03])?:? )?(?=[0-9X]{10}$|(?=(?:[0-9]+[- ]){3})[- 0-9X]{13}$|97[89][0-9]{10}$|(?=(?:[0-9]+[- ]){4})[- 0-9]{17}$)(?:97[89][- ]?)?[0-9]{1,5}[- ]?[0-9]+[- ]?[0-9]+[- ]?[0-9X]$/;
    var emailpattern = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
    var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    var statearr =  ["AK","AL","AR","AS","CA","CO","DC","DE","FL","GA","GU","HI",
     "IA","ID","IL","IN","KS","KY","LA","MD","ME","MN","MO","MS","MT","NC","ND",
     "NE","NH","NM","NY","OH","OK","OR","PA","PR","RI","SC","SD","TN","TX","UT",
     "VA","VT","WA","WI","WV","WY"];
 
 if($('#level').val() === "Admin")
     $("#promote").hide();
 
 
$('#indexsubmit').on("click",function(){
   
    if($.trim($('#hiddenfld').val()).length !== 0)
    $('#sign').hide();
       
  
     });
     
     
      $('#upSubmit').on("click",function(event){
           event.preventDefault();
           var isbn = $.trim($('#pubisbn').val());
           var imgname = $.trim($('#img').val());
                      
           var retrievedFields = checkFields(isbn);   
           if (retrievedFields == false) {return;}         
           if(checkImage(imgname) == false){return;}
           
           var ratio = document.getElementById('ratio');
           if (ratio.checked){
                    aspectratio = "yes";
             }
           var form_data = new FormData();       
           form_data.append("img", document.getElementById("img").files[0]);
           form_data.append("isbn",isbn );
           form_data.append("title",sendtitle );
           form_data.append("author", sendauth);
           form_data.append("ratio", aspectratio);
           var xhr = new XMLHttpRequest();
           xhr.open('POST', 'thumbnail.py', true);
           xhr.onload = function () {
           if (xhr.status === 200) {   
           window.location.href="imagehandle.php?action=change&&to=teaser&&isbn="+isbn;
           
           } else {
           $('#uploaderr').text("Error Occured in Uploading");
           $('#uploaderr').css("color","#FFCCCC");
           }
           };
          xhr.send(form_data);
          });
    
    
    $('#pubisbn').on('blur',function(){
        checkFields($.trim($('#pubisbn').val()));
    });
    
    function checkFields(isbn)
    {
       
        if(isbn.length != 0)
        {
        var url = "authhandle.php?action=pubcheck&isbn="+isbn;
        var req = new HttpRequest(url,checkhandle);
        req.send();
        }
         else
        {
          $('#uploaderr').text("*ISBN Required");
          $('#uploaderr').css("color","#FFCCCC");
          return false;  
        }
        
    }
    
    function checkhandle(response){
       
           if($.trim(response) == "invalid")
           {
              $('#uploaderr').text("*ISBN Invalid");
              $('#uploaderr').css("color","#FFCCCC");
           }
           else
           {   
            sendtitle = $.trim(response).split("||")[0];
            
           $('#pubtitle').val(sendtitle);
           sendauth = $.trim(response).split("||")[1];
             
           }
    }
    
    function checkImage(imgname){
        if(imgname.length !=0 )
        {
           
            var extension = imgname.split(".")[1];
             
            if(!($.trim(extension.toUpperCase())=="JPG")||($.trim(extension.toUpperCase())=="JPEG"))
            {
                
                $('#uploaderr').text("*Only JPG images are allowed");
                $('#uploaderr').css("color","#FFCCCC");
                return false;
            } 
            return true;
        }
        else
        {
          $('#uploaderr').text("*Image Required");
          $('#uploaderr').css("color","#FFCCCC");
          return false;  
        }
    }
    
    $('#upView').on('click',function(){
      var isbn = $.trim($('#pubisbn').val());
      if(isbn == "")
      {
         $('#uploaderr').text("*ISBN is Required to view images");
          $('#uploaderr').css("color","#FFCCCC"); 
      }
      else
      {
        window.location.href="imagehandle.php?action=check&&isbn="+isbn;
      }
    });
     
 $('#regsubmit').on("click",function(e){
     
    if($("[name='fname']").val().trim() == "") {
            $('#regstatus').text('Please provide your First Name');
            $("[name='fname']").focus();
            $('#regstatus').css("color","#FFB2B2");
            e.preventDefault(); 
            return;
            }
    if($("[name='lname']").val().trim() == "") {
            $('#regstatus').text('Please provide your Last Name');
            $("[name='lname']").focus();
            $('#regstatus').css("color","#FFB2B2");
            e.preventDefault(); 
            return;
            }
      if($("[name='add']").val().trim() == "") {
            $('#regstatus').text('Please provide your Address');
            $("[name='add']").focus();
            $('#regstatus').css("color","#FFB2B2");
            e.preventDefault(); 
            return;
            }
            
     if (($("[name='city']").val().trim() == "")||(!$("[name='city']").val().trim().match(/^[a-zA-Z\s]+$/)))
         {
            $('#regstatus').text('Please provide a valid City');
            $("[name='city']").focus();
            $('#regstatus').css("color","#FFB2B2");
            e.preventDefault(); 
            return;
         }
         
     if (($("[name='state']").val().trim() == "")||($.inArray($("[name='state']").val().trim().toUpperCase(),statearr)== -1))
         {
            $('#regstatus').text('Please provide a valid State');
            $("[name='state']").focus();
            $('#regstatus').css("color","#FFB2B2");
            e.preventDefault(); 
            return;
         }
         
     if (($("[name='zip']").val().trim() === "")||($.isNumeric($("[name='zip']").val().trim())===false)||($("[name='zip']").val().trim().length!==5))
         {
            $('#regstatus').text('Please provide a valid 5 digit Zip Code');
            $("[name='zip']").focus();
            $('#regstatus').css("color","#FFB2B2");
            e.preventDefault(); 
            return;
         }
         
     if (($("[name='phone']").val().trim() == "")||(!$("[name='phone']").val().trim().match(/^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]\d{3}[\s.-]\d{4}$/)))
         {
            $('#regstatus').text('Please provide a valid Mobile Number of the form xxx-xxx-xxxx');
            $("[name='phone']").focus();
            $('#regstatus').css("color","#FFB2B2");
            e.preventDefault(); 
            return;
         }
      if (($("[name='lphone']").val().trim() == "")||(!$("[name='lphone']").val().trim().match(/^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]\d{3}[\s.-]\d{4}$/)))
         {
            $('#regstatus').text('Please provide a valid Landline Number xxx-xxx-xxxx');
            $("[name='lphone']").focus();
            $('#regstatus').css("color","#FFB2B2");
            e.preventDefault(); 
            return;
         }
         
       if (($("[name='email']").val().trim() == "")||(!$("[name='email']").val().trim().match(re)))
         {
            $('#regstatus').text('Please provide a valid Email');
            $("[name='email']").focus();
            $('#regstatus').css("color","#FFB2B2");
            e.preventDefault(); 
            return;
         }
         
        if (($("[name='rpass']").val().trim() === "")||($("[name='rpass']").val().trim().length<8))
         {
            $('#regstatus').text('Please provide a password with atleast 8 characters');
            $("[name='rpass']").focus();
            $('#regstatus').css("color","#FFB2B2");
            e.preventDefault(); 
            return;
         }
        
        if ($("[name='rpass']").val().trim() !== $("[name='repass']").val().trim())
         {
            $('#regstatus').text('Retyped Password and Passoword does not look the same');
            $("[name='repass']").focus();
            $('#regstatus').css("color","#FFB2B2");
            e.preventDefault(); 
            return;
         }
          if($("[name='quest']").val().trim() == "") {
            $('#regstatus').text('Please decide your Security Question');
            $("[name='quest']").focus();
            $('#regstatus').css("color","#FFB2B2");
            e.preventDefault(); 
            return;
            }
          if ($("[name='ans']").val().trim().length === 0)
         {
            $('#regstatus').text('Please provide the answer for your Security Question');
            $("[name='ans']").focus();
            $('#regstatus').css("color","#FFB2B2");
            e.preventDefault(); 
            return;
         }
        
     
 });    
 
 
 if($('#hideuserbox').val()=== "yes")
 {
     $(".userdetails").show();
 }
 
 $('.removebest').on("click",function(event){
     
     var buttonid = event.target.id;
     var isbn = buttonid.replace('rbid','rid');  
     isbn = "#"+isbn;
     var isbnval = $(isbn).val();
     var url = "publisherhandle.php?action=remove&isbn="+isbnval;
     var req = new HttpRequest(url,pubhandler);
     req.send();
    
 });
 
 $('.addbest').on("click",function(event){
     
     var buttonid = event.target.id;
     var isbn = buttonid.replace('abid','aid');  
     isbn = "#"+isbn;
     var isbnval = $(isbn).val();
     var url = "publisherhandle.php?action=add&isbn="+isbnval;
     var req = new HttpRequest(url,pubhandler);
     req.send();
    
 });
 
 $('.cost').on("change",function(event){
     var inputid = event.target.id;
     var isbnid = inputid.substring(7,inputid.length);
     var  btntype = inputid.substring(0,1);
     isbnid = "#"+btntype+"id"+isbnid;
     var isbnval = $(isbnid).val();
     inputid = "#"+inputid;
     var inputval = $(inputid).val();
     var inputNumber = Number(inputval);
     if(inputNumber > 0)
     {
     var url = "publisherhandle.php?action=cost&isbn="+isbnval+"&cost="+inputval;
     var req = new HttpRequest(url,pubhandler);
     req.send();
     }
     else
     {
     $("html, body").animate({scrollTop: $("#publish").offset().top});     
     $('#publisherr').text("Error: Invalid value for cost. Changes will not be saved for ISBN "+isbnval);
     $('#publisherr').css("color","#FFB8B8");
     
     }
   
 });
 
 $('.pchk').on("change",function(event){
    
     var inputid = event.target.id;
     var isbnid = inputid.substring(4,inputid.length);
     var  btntype = inputid.substring(0,1);
     isbnid = "#"+btntype+"id"+isbnid;
     var isbnval = $(isbnid).val();
     inputid = "#"+inputid;
     if($(inputid).is(":checked"))    
     {var url = "publisherhandle.php?action=Publish&isbn="+isbnval;}
     else
     {var url = "publisherhandle.php?action=Unpublish&isbn="+isbnval;}
     
     var req = new HttpRequest(url,pubhandler);
     req.send();
   
 });
 
 function pubhandler(response){
   
  if($.trim(response) === "done")
  {
     window.location.href = 'publisher.php';
 
  }
 }
 
 $('.cartadd').on("click",function(event){
     
     var buttonid = event.target.id;
     var isbn = buttonid.replace('cartbtnid','cartinput');  
     isbn = "#"+isbn;
     var isbnval = $(isbn).val();
     var url = "carthandle.php?action=add&isbn="+isbnval;
     
     var req = new HttpRequest(url,carthandler);
     req.send();
    
 });
 
 function carthandler(response){
     
  if(response === "done")
  {
     url =  window.location.href;
   window.location.href = url;
  
  
  }
 }
 
 function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}

 $('.bcartadd').on("click",function(event){
     
     var buttonid = event.target.id;
     var isbn = buttonid.replace('bcartbtnid','bcartinput');  
     isbn = "#"+isbn;
     var isbnval = $(isbn).val();
     var url = "carthandle.php?action=add&isbn="+isbnval;
     var req = new HttpRequest(url,bcarthandler);
     req.send();
    
 });
 
 
 
 function bcarthandler(response){
    
  if(response === "done")
  {
     window.location.href = 'bestseller.php';
  }
 }
 
 $('.mdel').on("click",function(event){
     
     var buttonid = event.target.id;
     var isbn = buttonid.replace('middel','misbn');  
     isbn = "#"+isbn;
     var isbnval = $(isbn).val();
     var url = "carthandle.php?action=delete&isbn="+isbnval;
     var req = new HttpRequest(url,memberhandler);
     req.send();
    
 });
 
 $('.mqty').on("change",function(event){
     var buttonid = event.target.id;
     var qtyid = "#"+buttonid;
     var qty = $(qtyid).val();
     var isbn = buttonid.replace('midqty','misbn');  
     isbn = "#"+isbn;
     var isbnval = $(isbn).val();
     var qtyNumber = Number(qty);
     if(qtyNumber > 0 )
     {
       checkout = 0;
       $('#checkout').attr('disabled',false);
     var url = "carthandle.php?action=update&isbn="+isbnval+"&qty="+qty;
     var req = new HttpRequest(url,memberhandler);
     req.send();
   
     }
     else
     {
         var span = buttonid.replace('midqty','midspan');
         span = "#"+span;
         $(span).show();
         checkout = 1;
          $('#checkout').attr('disabled',true);
     }
 
    
 });
 
 
 
 function memberhandler(response){
  
    if(response === "done")
  {
     window.location.href = 'member.php';
  }  
 }
 
 $('#chk').click(function(){
    if (this.checked) {
        
        $('#sfname').val($('#fname').val());
        $('#slname').val($('#lname').val());
        $('#sphone').val($('#phone').val());
        $('#semail').val($('#email').val());
        $('#saddress1').val($('#address1').val());
        $('#szip').val($('#zip').val());
        $('#scity').val($('#city').val());
        $('#sstate').val($('#state').val());
        
        
    }
}) ;

$('#sortorder').change(function(){
   
    var sortval = $('#sortorder').val();
    var req = new HttpRequest("sorthandle.php?sortval="+sortval,sorthandler);
    req.send();
    
});

function sorthandler(response)
{
   
  window.location.href = "index.php";
   
}

$('#authisbn').change(function(){
     
     var isbnval = $.trim($('#authisbn').val());
    if(isbnval != "")
    {
        
     if(!isbnval.match(regexisbn))
     {
      $('#errorauthor').text("Invalid ISBN Format. Accepted Standards: ISBN-10 AND ISBN -13");
      $('#errorauthor').css("color","#800000");
      inputsdisable();
     }
     else
     {
     var url = "authhandle.php?action=check&isbn="+isbnval;
     var req = new HttpRequest(url,authhandler);
      req.send();
     }
 }
    
 });
 
 function authhandler(response)
 {
     if($.trim(response) === "Not Eligible")
     {
       $('#errorauthor').text("ISBN is used by the book for which you are not the author.");
       $('#errorauthor').css("color","#800000");
       inputsdisable();
     }
     else 
     {
     if($.trim(response) === "Add")
     {
       $('#errorauthor').text("ISBN is available for Addition.");
       $('#errorauthor').css("color","#DBFFB8");
       inputsenable();
       $("#authEdit").attr("disabled", true); 
       $("#authDel").attr("disabled", true); 
       $("#authAdd").attr("disabled", false);
       $("#title").val("");
       $("#edi").val("");
       $("#desc").val("");
       $("#imgname").val("");
       $('#apic').hide();
     }
     else
     {
      
       $('#errorauthor').text("ISBN is available for Edition and Deletion. ");
       $('#errorauthor').css("color","#DBFFB8");
       inputsenable();
       $("#authEdit").attr("disabled", false); 
       $("#authDel").attr("disabled", false); 
       $("#authAdd").attr("disabled", true);
       $("#title").val((response.split("||"))[0]);
       $("#edi").val((response.split("||"))[1]);
       $("#desc").val((response.split("||"))[2]);
       var imgname = response.split("||")[3];
       $('#apic').show();
       $('#apic').attr("src","images/"+imgname);
       $("#imgname").val((response.split("||"))[3]);
     }
    }
 }
 function inputsenable(){
     $("#title").attr("disabled", false); 
     $("#edi").attr("disabled", false);
     $("#desc").attr("disabled", false); 
     $("#img").attr("disabled", false);
    
 }
 
 function inputsdisable(){
     $("#title").attr("disabled", true); 
     $("#edi").attr("disabled", true);
     $("#desc").attr("disabled", true); 
     $("#img").attr("disabled", true);
     $("#authEdit").attr("disabled", true); 
     $("#authDel").attr("disabled", true); 
     $("#authAdd").attr("disabled", true);
    
 }

    
 $('#authAdd').on("click",function(event){
  var isbnval = $.trim($('#authisbn').val());
  
    var isvalid = input_validation();
     
      if(isvalid)
    {
    if(isbnval != "" && isbnval.match(regexisbn))
    {
     send_file(); 
     var url = "authhandle.php?action=add&isbn="+isbnval+"&title="+$.trim($('#title').val())+"&edition="+$.trim($('#edi').val())+"&desc="+$.trim($('#desc').val())+"&img="+$.trim($('#imgname').val());
     var req = new HttpRequest(url,operhandler);
     req.send(); 
  
    }
    else
    {
     
    $('#errorauthor').text("Invalid ISBN Format. Accepted Standards: ISBN-10 AND ISBN -13");
    $('#errorauthor').css("color","#800000");
    inputsdisable();
    
    }
    }
    return false;   
 });
 
 $('#authEdit').on("click",function(event){
     
      var isbnval = $.trim($('#authisbn').val());
      var isvalid = input_validation();
      
      if(isvalid)
      {
     if(isbnval != "" && isbnval.match(regexisbn))
        {
        send_file();     
        var url = "authhandle.php?action=update&isbn="+isbnval+"&title="+$.trim($('#title').val())+"&edition="+$.trim($('#edi').val())+"&desc="+$.trim($('#desc').val())+"&img="+$.trim($('#imgname').val());
        var req = new HttpRequest(url,operhandler);
        req.send(); 
  
        }
     else
       {
     
        $('#errorauthor').text("Invalid ISBN Format. Accepted Standards: ISBN-10 AND ISBN -13");
        $('#errorauthor').css("color","#800000");
        inputsdisable();
    
       }
      }
    return false;   
     
 });
 
 $('#authDel').on("click",function(event){
 
   var isbnval = $.trim($('#authisbn').val());
    if(isbnval != "" && isbnval.match(regexisbn))
    {
       
  var url = "authhandle.php?action=delete&isbn="+isbnval;
  var req = new HttpRequest(url,operhandler);
  req.send(); 
  
    }
    else
    {
     
    $('#errorauthor').text("Invalid ISBN Format. Accepted Standards: ISBN-10 AND ISBN -13");
    $('#errorauthor').css("color","#800000");
    inputsdisable();
    
    }
    return false;
 });
 
 function operhandler(response){

  var isbnval = $.trim($('#authisbn').val());
  response = $.trim(response);
  
  if(response === "Inserted")
  {
      $('#errorauthor').text(isbnval+"  Successfully Added");
  }
  if(response === "Edited")
  {
     
       $('#errorauthor').text(isbnval+"  Successfully Edited");
      
  }
  if(response === "deleted")
  {
       $('#errorauthor').text(isbnval+"  Successfully Deleted");
  }
   $('#errorauthor').css("color","#DBFFB8");
   $("#authisbn").val("");
   $("#title").val("");
   $("#edi").val("");
   $("#desc").val("");
   $("#imgname").val("");
    $('#apic').hide();
 }
 
 $('#img').on("blur",function(event){
     $("#imgname").val($('#img').val());
 });
 
 function send_file() {    
        var form_data = new FormData($('#authform')[0]);       
        form_data.append("img", document.getElementById("img").files[0]);
        $.ajax( {
            url: "fileupload.php",
            type: "post",
            data: form_data,
            processData: false,
            contentType: false,
            success: function(response) {
              
                },
            error: function(response) {
              $('#errorauthor').text("Upload Error Occured");
              $('#errorauthor').css("color","#800000");
              
                }
            });
			}
                        
                        
        function input_validation(){
           
            $('#errorauthor').css("color","#800000");
            if($.trim($('#title').val()) == "")
            {
                $('#errorauthor').text("Book Title should not be empty");
                return false;
            }
            if(($.trim($('#edi').val()) == "")||(!$.isNumeric($.trim($('#edi').val()))))
             {
                $('#errorauthor').text("Book Edition should not be empty and shouble be an integer");
                return false;
            }  
            
            if($.trim($('#img').val()) != "")
            {
            var extension = $('#img').val().split('.').pop().toUpperCase();
    
            if (extension != "PNG" && extension !="JPG" && extension != "GIF" && extension != "JPEG")
             {
                $('#errorauthor').text("Book Image should be of types PNG,JPG,GIF or JPEG");
                return false;
            }
           }
            return true;
            
        }
        
       
        
        $('#firstlogin').on('submit',function(){
            
           if($.trim($('#email').val()).length > 0)
            {
                var email = $.trim($('#email').val());
                if(!email.match(emailpattern))
                {
                    $('#errorindex').text("Invalid Email format");
                    return false;
                }
                
            }
            else
            {
                 $('#errorindex').text("Email id is empty");
                return false;
            }
            if($.trim($('#pwd').val()).length > 0)
            {
               return true;
            }
            else
            {
                $('#errorindex').text("Password is empty");
                return false;
            }
      
        });
        
        $('#adminform').on('submit',function(){
            
           if($.trim($('#useremail').val()).length > 0)
            {
                var email = $.trim($('#useremail').val());
                if(!email.match(emailpattern))
                {
                    $('#erroradmin').text("Invalid Email format");
                    return false;
                }
                
            }
            else
            {
                 $('#erroradmin').text("Email id is empty");
                return false;
            }
           
      
        });
        
        
$('#startshopping').on('click',function(){
window.location.href = 'index.php';

});

$('#changesubmit').on('click',function(){
    var rpass = $.trim($('#rpass').val());
    var repass = $.trim($('#repass').val())
   if((rpass && !repass)||(!rpass && repass))
   {
       alert("Password and Retype password has to be same");
       return false;
   }
   if(rpass.length < 8)
   {
       alert("Password length has to be atealse 8 characters");
       return false;
   }
   if(rpass != repass)
   {
       alert("Password and Retype password has to be same");
       return false;
   }
   
   return true;
});

$('#checkoutsubmit').on('click',function(){
  
    return isvalid();
});

function isvalid(){
  
var mm = $.trim($('#mm').val());
var yy = $.trim($('#yy').val());
for(var i=0;i<idarr.length;i++)
{
idarr[i].css("border-color","black");
$('#paytype').css("border-color","black");
var idval = $.trim(idarr[i].val());
if(idval.length == 0)
{
idarr[i].focus();
idarr[i].css("border-color","red");
$('#vmsg').html("*All fields are required and cannot be empty. Second Line of Address is optional");
return false;
}}


if($.trim($('#ctype').val())==='so')
{
$('#ctype').focus();
$('#ctype').css("border-color","red");
$('#vmsg').html("*Select one of payment type");
return false;
} 


if(($.isNumeric(mm) == false)|| (mm>12) || (mm<0) || ($.isNumeric(yy) == false) || (yy<2014))
{
$("#yy").css("border-color","red");
$("#mm").css("border-color","red");
$('#vmsg').html("*Enter valid Expiration date");
return false;
}


for(var j=0;j<zipid.length;j++)
{
var zipval = $.trim(zipid[j].val());
if(($.isNumeric(zipval) == false)||(zipval.length != 5))
{
zipid[j].focus();
zipid[j].css("border-color","red");
$('#vmsg').html("ZipCode must be 5 digits and numeric");
return false;
}
}

for(var j=0;j<phone.length;j++)
{
var phoneval = $.trim(phone[j].val());
if(!phoneval.match(/^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]\d{3}[\s.-]\d{4}$/))
{
phone[j].focus();
phone[j].css("border-color","red");
$('#vmsg').html("Phone number must be of the format xxx-xxx-xxxx");
return false;
}
}

for(var j=0;j<email.length;j++)
{
var emailval = $.trim(email[j].val());
if(!emailval.match(emailpattern))
{
email[j].focus();
email[j].css("border-color","red");
$('#vmsg').html("Email id should be valid");
return false;
}
}

for(var j=0;j<city.length;j++)
{
var cityval = $.trim(city[j].val());

if(!cityval.match(/^[a-zA-Z\s]+$/))
{
city[j].focus();
city[j].css("border-color","red");
$('#vmsg').html("City Name should not contain numbers ");
return false;
}
}

for(var j=0;j<state.length;j++)
{
var stateval = $.trim(state[j].val());
if(($.inArray(stateval.toUpperCase(),statearr)== -1))
{
state[j].focus();
state[j].css("border-color","red");
$('#vmsg').html("State name should not contain numbers and should be a valid state code");
return false;
}
}

var cval = $.trim($('#cnum1').val());
if(($.isNumeric(cval) == false)||(cval.length != 16))
{
$('#cnum1').focus();
$('#cnum1').css("border-color","red");
$('#vmsg').html("Card Number must be numeric and Contain 16 digits");
return false;
}

return true;
}
 
 $.jqplot.config.enablePlugins = true;
        var s1 = [];
        var ticks = [];
 
 var chart_url="../../api/get_books.php";
    var chart_req = new HttpRequest(chart_url,chart_handler);
     chart_req.send();
     
     function chart_handler(response)
     {
         var json = $.trim(response).split("Raw JSON\n\n")[1];
         var obj = JSON.parse(json);
         for(var i = 0;i<obj.length;i++)
         {
             s1.push(obj[i].sold);
             ticks.push(obj[i].Title);
         }
       plot1 = $.jqplot('chart1', [s1], {
           
            animate: !$.jqplot.use_excanvas,
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
                pointLabels: { show: true }
            },
            axes: {
                xaxis: {
                    
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks
                    
                },
                yaxis: {
                    min: 10,
                    max: 300
                }
            },
            highlighter: { show: false }
        });
    
        $('#chart1').bind('jqplotDataClick', 
            function (ev, seriesIndex, pointIndex, data) {
                $('#info1').html('series: '+seriesIndex+', point: '+pointIndex+', data: '+data);
            }
        );

     }
     

 

});