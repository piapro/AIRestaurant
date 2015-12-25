//SETUP//


var containerStat = 0		  //Container visible prior to images are loaded on/off
var toggleSpeed = 1000        //Dropdown speed - possible values: slow,normal,fast or xxxx milliseconds 
var percentComplete = "37%"   //% complete - sets bar location and bar % display
var barSpeed = 1500           //Bar animation speed in milliseconds
var animationDelay =800	  	  //Bar and tip start animation delay in milliseconds
var fadeSpeedIcons = "fast"   //Social icons hover speed - possible values: slow,normal,fast or xxxx milliseconds
var Year =  2011			  //Set the year
var Month  = 10				  //Set the month
var Day = 18				  //Set the day
var Hour = 22				  //Set the hour of the day
var Min = 30                   //Set the Min
var Sec = 0                   //Set the Sec

//Social network ids - only fill out the ids, not the full url
var facebookPageID ="UnlimitDesign/167541586629542"
var twitterID = "orpinlee"
var myspaceID = "leosin"
var skypeID ="udfrance"

//Contact from messages
var formBorderVerify = '1px solid #d95880'  //width, type, color can be changed
var formError="邮件发送超时. 请5分钟后重试！"
var formWarning ="请填写完整后重试!"
var formSuccess ="感谢您的留言，我们将在24小时内回复您！"
var formSuccessTitle ="留言发送成功"
var formReload ="请在此留言我们将在24小时之内回复您."
var formReloadTitle ="您的留言内容..."

//Notify field messages
var notifyError ="Sorry, 发现一个错误, 请重新尝试！"
var notifyWarning ="Invalid e-mail, try again!"
var notifySuccess ="E-mail added, you'll be notified when we launch!"


//SUPERSIZE VARIABLE
jQuery(function($){
				$.supersized({
				
//Functionality

slideshow               :   1,		//Slideshow on/off
autoplay				:	1,		//Slideshow starts playing automatically
start_slide             :   1,		//Start slide (0 is random)
random					: 	0,		//Randomize slide order (Ignores start slide)
slide_interval          :   3000,	//Length between transitions
transition              :   1, 		//0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
transition_speed		:	1000,	//Speed of transition
performance				:	1,		//0-Normal, 1-Hybrid speed/quality, 2-Optimizes image quality, 3-Optimizes transition speed // (Only works for Firefox/IE, not Webkit)
image_protect			:	1,		//Disables image dragging and right click with Javascript
keyboard_nav            :   0,		//Keyboard navigation on/off

				
slides 					:  	[		//Slideshow Images
							{image : 'images/index_bg.jpg', title : 'Recent Graphics Title'},  
							{image : 'images/index_bg.jpg', title : 'Recent Graphics Title2'},  
							{image : 'images/index_bg.jpg', title : 'Recent Photo Title'}, 
							{image : 'images/index_bg.jpg', title : 'Recent Photo Title 2'}   
							]
												
	}); 
});