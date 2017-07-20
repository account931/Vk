<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
                 

</script>

<style>
#vkAuth1   {display:none;}
#examples  {font-size:9px;cursor:pointer;}
#examplHidden {display:none;font-size:10px;}
.boxedshadow{box-shadow: 0 0 10px rgba(0,0,0,1.5);}
.pargr {color:black;font-size:32px;} /*nessageBox.tpl*/
.boxedshadowSmall{box-shadow: 0 0 10px rgba(0,0,0,1.5);width:70%;}
</style>
</head>
<body>





<!--http://lifeexample.ru/php-primeryi-skriptov/kak-rabotat-s-vk-api-vkontakte.html-->
<!--
//for  dumbs  only=>https://new.vk.com/dev/methods;
//https://api.vk.com/method/wall.get?owner_id=170505996=>  example  with Petya. Check parameters=>[owner_id]!!!, not  user_id  as  in users.get;
-->




<center>
<div>

<p class="pargr boxedshadow" id="vkSwitcher" >Click  here  to  switch</p></div>








<!-------------------------------------  START Hidden  Vk users  info  ------------------------------------------------------->
<!-- First Start JS code  for Hidden  Vk users  info -->
<script>
// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **
$(document).ready(function(){



//Switcher---------------

   $("#vkSwitcher").click(function(){
                 if( $('#vkAuth1').is(':visible'))
                     {
                        $("#vkAuth1").hide(1000);  
                        $("#vkInfo").show(1000);                                                 
                       }// end  if 
                   else { $("#vkInfo").hide(1000);  
                          $("#vkAuth1").show(1000);    }
});

  

 $("#examples").click(function(){
               $("#examplHidden").toggle(1000);  
});
    
//End  Switcher ----------





// Start Allow  to  checkBox  only  one  itembox at once;
$('input[type="checkbox"]').on('change', function() {
    $('input[name="' + this.name + '"]').not(this).prop('checked', false); });
// End Start Allow  to  checkBox  only  one  item;


// Start6 Clicking  Get  Button
    $("#vkButton").click(function(){

                 //getting  User  Id;
              var UserIDProvided=$('#vkUserId').val(); //alert(UserIDProvided);







            //checking  if  1st checkbox  is  checked =User Info_pics
           //**************************************************************
                    if ($('#check1').prop('checked'))  {alert("1 ch");
                         // Start Ajax Check 1
                         $.getJSON('https://api.vk.com/method/users.get?uids='+UserIDProvided+'&fields=first_name,last_name,country,city,photo_medium,photo_big,bdate,photo_rec,about,screen_name,contacts,status&callback=?', function(resp){
                        // alert(JSON.stringify(resp, null, 4)); alert(resp.response[0].photo_big); 
                         $("#info1").html(resp.response[0].first_name+" "+resp.response[0].last_name+"</br>"+resp.response[0].photo_big+"</br><img src="+resp.response[0].photo_big+ ">")
                             });
                  // End  Ajax  Check 1

                                             } //  end if 1st checkbox  is  checked ($('#check1').prop('checked')) 
                  //---------------------------------------------------------









// Start  getting 2nd  checkbox  wall=text+pictures;
//************************************************************************************************************
  // Start checking  if  2st checkbox  is  checked=WAlls
                       if ($('#check2').prop('checked'))  { var UserIDProvided=$('#vkUserId').val();  // if  u  cheboxed  the  2nd  checkbox

                                //check if  input  is number  of  nickname to  form  different Ajax  URL (owner_id/domain);
                                  if (isNaN(UserIDProvided)) {var URL='https://api.vk.com/method/wall.get?domain='+UserIDProvided+'&callback=?'} 
                                                else{var URL='https://api.vk.com/method/wall.get?owner_id='+UserIDProvided+'&callback=?'}

                         // Start Ajax Check 2
                         $.getJSON(URL,function(respp){
                          alert(JSON.stringify(respp, null, 4));  alert(respp.response[1].text); // aleting  wall  text;
  var lengthR = Object.keys(respp.response).length;  alert("length is  => "+lengthR);//  Get  the  length of  reurned  JSON Oblect-array;
                         //$("#info1").html(respp.response[1].text);

                           alert("!!!photo=> "+respp.response[2].attachment.photo.src); //  alert  the path to 1  specific   image(just  for  test);
                           var MySrc; //var  that will  contain  src  fot  images/pictures;
                              
                              //starting  "for()" loop  with  Json  response length; // in loop  we  test if< <img  src>  exist for  every  itteration (typtof)
                              //the  problem, that some array[i] do not contain images,just  text and if  it  is  not,it  crashes &stopps everything (so use-> try{}-catch()) 
                           for (var i = 1; i < lengthR; i++) 
                                            {if(typeof respp.response[i].attachment != 'undefined')  {try{ MySrc=respp.response[i].attachment.photo.src}catch(e){} } else{MySrc="http://download.mgccw.com/mu3/app/20141022/07/1413942254438/icon/icon_l.png"};
                                             var finalText= finalText+respp.response[i].text+"</br><img src="+MySrc+"></br>"}

                         $("#info1").html(finalText); //if(typeof respp.response[i].attachment.photo.src == "undefined") ; //if(x && typeof x.y != 'undefined')  
                             });
                               // End  Ajax  Check 2

                                             } //  end if 2st checkbox  is  checked ($('#check2').prop('checked')) 
//----------------------------------------------------------------------------------------------------




                    


                      // Start  getting 3nd  checkbox Friends;
                     //************************************************************************************************************
                       // Start checking  if  3st checkbox  is  checked=Friends;
                       if ($('#check3').prop('checked'))  { var UserIDProvided=$('#vkUserId').val();  //  should  comment  this ; 

                               // Start  isNaN(UserIDProvided))==check ifused  nickname/domain instead  of  ID(the  problem=no methods  for  domain, have  to  convert  to  id  first);
                              //check if  input  is number  or  nickname (if it's  nickname convert to ID);
                                if (isNaN(UserIDProvided)) { alert("NaN"); $.getJSON('https://api.vk.com/method/users.get?uids='+UserIDProvided+'&callback=?', function(resp){ alert(resp.response[0].uid); var UserIDProvided=resp.response[0].uid;  UserIDProvided=parseInt(UserIDProvided);  $('#vkUserId').val(UserIDProvided);/*put the  converted ID to input*/  jQuery('#vkButton')[0].click();/*emulate click & input  now  contains ID*/   });
                                                           } else {var UserIDProvided=$('#vkUserId').val();}
                              // End isNaN(UserIDProvided))==used  nickname/domain instead  of  ID;
                                                        
                         // Start Ajax Check 3
                         $.getJSON('https://api.vk.com/method/friends.get?user_id='+UserIDProvided+'&fields=nickname,photo_100&callback=?',function(respp){

                          //alert(JSON.stringify(respp, null, 4));  alert(respp.response[0].first_name); // alerting  friends;
  var lengthR = Object.keys(respp.response).length;  alert("Number of  friends  => "+lengthR);//  Get  the  length of  returned  JSON Oblect-array;
                         
                              
                              //starting  "for()" loop  with  Json  response length;
                                var finalText="<table>"; 
                           for (var i = 0; i < lengthR; i++) //!!!!
                                            
                                            {
                                            var finalText= finalText+"<tr><td>"+respp.response[i].first_name +"</td><td> "+respp.response[i].last_name+ "</td><td> <img src="+respp.response[i].photo_100+"></td></tr>" }
                                            finalText= finalText+"</table>";
                                            $("#info1").html(finalText); 
                                             });
                               // End  Ajax  Check 3

                                             } //  end if 3st checkbox  is  checked ($('#check3').prop('checked')) 

                      //End   getting 3nd  checkbox Friends;
                     //----------------------------------------------------------------------------------------------------














                // Start  getting 4nd  checkbox  User's  profiled  photos;
               //************************************************************************************************************
 // Start checking  if  4st checkbox  is  checked=profiled  photos;
                       if ($('#check4').prop('checked'))  { var UserIDProvided=$('#vkUserId').val();  //  should  comment  this ; 

                               // Start  isNaN(UserIDProvided))==check ifused  nickname/domain instead  of  ID(the  problem=no methods  for  domain, have  to  convert  to  id  first);
                              //check if  input  is number  or  nickname (if it's  nickname convert to ID);
                                if (isNaN(UserIDProvided)) { alert("NaN"); $.getJSON('https://api.vk.com/method/users.get?uids='+UserIDProvided+'&callback=?', function(resp){ alert(resp.response[0].uid); var UserIDProvided=resp.response[0].uid;  UserIDProvided=parseInt(UserIDProvided);  $('#vkUserId').val(UserIDProvided);/*put the  converted ID to input*/  jQuery('#vkButton')[0].click();/*emulate click & input  now  contains ID*/   });
                                                           } else {var UserIDProvided=$('#vkUserId').val();}
                              // End isNaN(UserIDProvided))==used  nickname/domain instead  of  ID;
                                                        
                         // Start Ajax Check 4
                         $.getJSON('https://api.vk.com/method/photos.get?owner_id='+UserIDProvided+'&album_id=profile&callback=?',function(respp){

                          //alert(JSON.stringify(respp, null, 4));  alert(respp.response[0].src_big); // alerting  friends;
  var lengthR = Object.keys(respp.response).length;  alert("Number of  photos  => "+lengthR);//  Get  the  length of  returned  JSON Oblect-array;
                         
                              
                              //starting  "for()" loop  with  Json  response length;
                               
                           for (var i = 0; i < lengthR; i++) //!!!!
                                            {                                          
                                            var finalText=finalText+"<img src="+respp.response[i].src_big+"></br>";
                                             }//  end  For  loop
                                            $("#info1").html(finalText); 
                                             });
                               // End  Ajax  Check 4

                                             } //  end if 4st checkbox  is  checked ($('#check3').prop('checked')) 


                // Start  getting 4nd  checkbox  User's  profiled  photos;
                //-------------------------------------------------------------------------------------------------
 












                 






  
    }); //  end    Clicking  Get  Button

}); //doc       ready
// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************

</script>
<!-- END  JS code  for Hidden  Vk users  info -->










<!--  HTML  code  for Hidden  Vk users  info-Second  page -->
<div id="vkInfo">
<p class=" boxedshadowSmall"  >Get any Vk User  Info</p>
<img id="examples" src="images/imgvk.jpg" style="width:130px;"  title="click  for  examples"/>
<p style="font-size:12px;" id="examplesDELETE">examples</p>
<span id="examplHidden">127661472</br>olgabuzova</br>170505996</br></br></span>
<form> 
User Id <input type="text" placeholder=" User Id u'd like  to look " id="vkUserId" title="170505996 " required />
<table>
<tr><td><input type="checkbox" name="a" value="1417" id="check1">  User's  data</td></tr>
<tr><td><input type="checkbox" name="a" value="1680" id="check2"> User's  wall</td></tr>
<tr><td><input type="checkbox" name="a" value="1680" id="check3"> User's  Friends</td></tr>
<tr><td><input type="checkbox" name="a" value="1680" id="check4"> User's  Photos </td></tr>
<tr><td><input type="checkbox" name="a" value="1680" id="check5"> User's  last  visit </td></tr>
<tr><td><input type="button" id="vkButton" value=" Get it"/></td></tr>
</table>
</form>
<div id="info1"></div>
<div id="info2"></div>
<div id="check3"></div>
<div id="check4"></div>
</div>
<!--  END HTML  code  for Hidden  Vk users  info -->
<!-------------------------------------  END   Hidden  Vk users  info  ------------------------------------------------------->



























<!-------------------------------------------START  Vk  oauth (login-password) 1st  Page  ,appears  by  default------------------------>

<div id="vkAuth1">
<p id ="vk"></p><!-- Injected WORKING!!!-->
<p id ="vkPhoto"></p>
<p id ="vkTest">Ajax  response</p> <!-- just  to  test  ajax-->
<!--<a  href="http://vkontakte.ru/login.php?op=logout" >LOG IT OUT </a>-->













<!-- VK Injected WORKING!!! Proceeds  everything,  gets   data  and  photo-->
<script src="http://vkontakte.ru/js/api/openapi.js" type="text/javascript"></script>
<?php
// **************************************************************************************
// **************************************************************************************
// **                                                                                  **   
?>      
<div id="login_button" onclick="VK.Auth.login(authInfo);"></div>
<div id="logout_button" onclick="VK.Auth.logout;">LOG OUT</div>



 
<script language="javascript">
VK.init({
  apiId: 5465729  });
var appPermissions = "wall,groups,friends";
 
//Api  built  function .Used later in VK.Auth.login(authInfo, appPermissions);
function authInfo(response) {
  if (response.session) { ;alert(JSON.stringify(response, null, 4));  //alert  MINE and  see  what  if  brings  back(what  vars   to  use further);
    alert('user: '+response.session.mid); var vk=response.session.mid; 
                                          var vkUserId=response.session.mid;// user's  id  for  URL  , the  same  as  var  vk, just  different  name  not  to be confused  with  var  name;
                 //setting  SId  to  var to  use it  further;
                   var  MySid=response.session.sid; 
           
     //mine addition;
   $("#vk").html("User ID: "+vk +"</br>"+response.session.user.first_name+"</br>"+response.session.user.last_name+"</br> User profile: "+response.session.user.href+"</br>"+response.session.sid);
   

 
                                                 
        //Mine*** ajax  REQUEST WITH  PHOTO WORKSS(inside  the other  request)!!!!!!********************
                                          // **************************************************************************************
                                          // **************************************************************************************
                                          // **                                                                                  **   
     
                         $.getJSON('https://api.vk.com/method/users.get?access_token='+MySid+'&uids='+vkUserId+'&fields=first_name,last_name,country,city,photo_medium,photo_big,bdate,photo_rec,about,screen_name,contacts,status&callback=?', function(resp){
                         //$.getJSON('/*http://api.vkontakte.ru/method/users.get?uids=129136854&fields=photo_200,status&callback=?*/https://api.vk.com/method/users.get?access_token=4b861338681c52c5cb829be9a942532d6df518c3f26ef6ea3ad6d97a9e26ce422009b757cf3ac9be8bd4d&uids=129136854&fields=first_name,last_name,country,city,photo_medium,photo_big,bdate,photo_rec,about,screen_name,contacts', function(resp){
                         //console.log(resp.response[0].photo_200);
                         // console.log(resp.response[0].status);
                         alert("photo getJaSon  "+resp.response[0].photo_big);
                         $("#vkPhoto").html(resp.response[0].photo_big+"</br><img src="+resp.response[0].photo_big+ ">")
                             });
    //  END  Mine  REQUEST WITH  PHOTO WORKSS!!!!!!-------------------
                                          // **                                                                                  **
                                          // **************************************************************************************
                                          // **************************************************************************************

                            
   




                                           // Conctacting  oauth php  handler   to pass vars  to  SQL
                                          // **************************************************************************************
                                          // **************************************************************************************
                                          //                                                                                     **

                                      // send  the  name,photo  etc  to  PHP handler  ************ 
                            /*  $.ajax({
                                 url: 'http://example2.esy.es/mvc/templates/central/oauthHandler.php',
                                 type: 'GET',
                                 data: { phpFirstName:response.session.user.first_name, phpLasttName:response.session.user.last_name},
                                 success: function(data) {
                                 // do something;
                                 alert('done SQL');$('#vkTest').html(data)
                                 $('#result').html(data)
                                  }
                                          });*/

                                                   // }
                                               //  END AJAXed  part;
                                               //  
                                         //                                                                                   **
                                        // *************************************************************************************
                                       // **************************************************************************************




                                         
  //
  } else {     //if  is  not  authorized;
    alert('not authorized');  /*<?php  echo '<h1> Injected</h1>'; ?>*/  /*  may  reload  page  with $_GET trigger*/
    //window.location.href = "http://example2.esy.es/mvc/?oauth&vk=false";  //  works  but  reload  the  page  non-stop; 
          

            //  send  the  name,photo  etc  to  PHP ************ 
               /*$.ajax({
                        url: 'http://example2.esy.es/mvc/templates/central/oauthHandler.php',
                        type: 'GET',
                         data: { phpVar:"Ajax" },
                         success: function(data) {
                             //do something;
                               alert('done');$('#vkTest').html(data)
                            $('#result').html(data)
                         }
                     });*/
              }
          //  END AJAXed  part ;
} //  end  of function authInfo(response)????
 

//  some  Vk Api procedures;
VK.Auth.login(authInfo, appPermissions);
 
VK.UI.button('login_button');

// **                                                                                  **
// **************************************************************************************
// **************************************************************************************
</script>
<!--END Injected   END  PAGE  1 ??????????????????????????????-->













<!--  all below  is  not  used  at all !!!!!!!!!!!-->



































</div>
</center>





</body>
</html>

