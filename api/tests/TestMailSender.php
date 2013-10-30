<?php
require_once 'simpletest/autorun.php';
require_once '../Utils/MailSender.php';

class TestMailSender extends UnitTestCase {
// 	function testSendEmailToEveryone() {
// 		$this->assertTrue(MailSender::sendEmail(
// 				"claramoore@speakeasy.net,
// 				 tuanvo@uw.edu,
// 				dannych@uw.edu,
// 				ctjong@uw.edu,
// 				ynamara@cs.washington.edu,
// 				rsihongbing@gmail.com", "Email controller test", "Hello kids!\nThis email is sent from cubist"));
// 	}
	
	function testSendHTMLEmail() {
		$message = <<<EOF
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html><head><title></title><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><meta name="viewport" content="width=320, target-densitydpi=device-dpi">
<style type="text/css">
/* Mobile-specific Styles */
@media only screen and (max-width: 660px) { 
table[class=w0], td[class=w0] { width: 0 !important; }
table[class=w10], td[class=w10], img[class=w10] { width:10px !important; }
table[class=w15], td[class=w15], img[class=w15] { width:5px !important; }
table[class=w30], td[class=w30], img[class=w30] { width:10px !important; }
table[class=w60], td[class=w60], img[class=w60] { width:10px !important; }
table[class=w125], td[class=w125], img[class=w125] { width:80px !important; }
table[class=w130], td[class=w130], img[class=w130] { width:55px !important; }
table[class=w140], td[class=w140], img[class=w140] { width:90px !important; }
table[class=w160], td[class=w160], img[class=w160] { width:180px !important; }
table[class=w170], td[class=w170], img[class=w170] { width:100px !important; }
table[class=w180], td[class=w180], img[class=w180] { width:80px !important; }
table[class=w195], td[class=w195], img[class=w195] { width:80px !important; }
table[class=w220], td[class=w220], img[class=w220] { width:80px !important; }
table[class=w240], td[class=w240], img[class=w240] { width:180px !important; }
table[class=w255], td[class=w255], img[class=w255] { width:185px !important; }
table[class=w275], td[class=w275], img[class=w275] { width:135px !important; }
table[class=w280], td[class=w280], img[class=w280] { width:135px !important; }
table[class=w300], td[class=w300], img[class=w300] { width:140px !important; }
table[class=w325], td[class=w325], img[class=w325] { width:95px !important; }
table[class=w360], td[class=w360], img[class=w360] { width:140px !important; }
table[class=w410], td[class=w410], img[class=w410] { width:180px !important; }
table[class=w470], td[class=w470], img[class=w470] { width:200px !important; }
table[class=w580], td[class=w580], img[class=w580] { width:280px !important; }
table[class=w640], td[class=w640], img[class=w640] { width:300px !important; }
table[class*=hide], td[class*=hide], img[class*=hide], p[class*=hide], span[class*=hide] { display:none !important; }
table[class=h0], td[class=h0] { height: 0 !important; }
p[class=footer-content-left] { text-align: center !important; }
#headline p { font-size: 30px !important; }
.article-content, #left-sidebar{ -webkit-text-size-adjust: 90% !important; -ms-text-size-adjust: 90% !important; }
.header-content, .footer-content-left {-webkit-text-size-adjust: 80% !important; -ms-text-size-adjust: 80% !important;}
img { height: auto; line-height: 100%;}
 } 
/* Client-specific Styles */
#outlook a { padding: 0; }	/* Force Outlook to provide a "view in browser" button. */
body { width: 100% !important; }
.ReadMsgBody { width: 100%; }
.ExternalClass { width: 100%; display:block !important; } /* Force Hotmail to display emails at full width */
/* Reset Styles */
/* Add 100px so mobile switch bar doesn't cover street address. */
body { background-color: #ececec; margin: 0; padding: 0; }
img { outline: none; text-decoration: none; display: block;}
br, strong br, b br, em br, i br { line-height:100%; }
h1, h2, h3, h4, h5, h6 { line-height: 100% !important; -webkit-font-smoothing: antialiased; }
h1 a, h2 a, h3 a, h4 a, h5 a, h6 a { color: blue !important; }
h1 a:active, h2 a:active,  h3 a:active, h4 a:active, h5 a:active, h6 a:active {	color: red !important; }
/* Preferably not the same color as the normal header link color.  There is limited support for psuedo classes in email clients, this was added just for good measure. */
h1 a:visited, h2 a:visited,  h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited { color: purple !important; }
/* Preferably not the same color as the normal header link color. There is limited support for psuedo classes in email clients, this was added just for good measure. */  
table td, table tr { border-collapse: collapse; }
.yshortcuts, .yshortcuts a, .yshortcuts a:link,.yshortcuts a:visited, .yshortcuts a:hover, .yshortcuts a span {
color: black; text-decoration: none !important; border-bottom: none !important; background: none !important;
}	/* Body text color for the New Yahoo.  This example sets the font of Yahoo's Shortcuts to black. */
/* This most probably won't work in all email clients. Don't include code blocks in email. */
code {
  white-space: normal;
  word-break: break-all;
}
#background-table { background-color: #ececec; }
/* Webkit Elements */
#top-bar { border-radius:6px 6px 0px 0px; -moz-border-radius: 6px 6px 0px 0px; -webkit-border-radius:6px 6px 0px 0px; -webkit-font-smoothing: antialiased; background-color: #043948; color: #e7cba3; }
#top-bar a { font-weight: bold; color: #e7cba3; text-decoration: none;}
#footer { border-radius:0px 0px 6px 6px; -moz-border-radius: 0px 0px 6px 6px; -webkit-border-radius:0px 0px 6px 6px; -webkit-font-smoothing: antialiased; }
/* Fonts and Content */
body, td { font-family: HelveticaNeue, sans-serif; }
.header-content, .footer-content-left, .footer-content-right { -webkit-text-size-adjust: none; -ms-text-size-adjust: none; }
/* Prevent Webkit and Windows Mobile platforms from changing default font sizes on header and footer. */
.header-content { font-size: 12px; color: #e7cba3; }
.header-content a { font-weight: bold; color: #e7cba3; text-decoration: none; }
#headline p { color: #e7cba3; font-family: HelveticaNeue, sans-serif; font-size: 36px; text-align: center; margin-top:0px; margin-bottom:30px; }
#headline p a { color: #e7cba3; text-decoration: none; }
.article-title { font-size: 18px; line-height:24px; color: #9a9661; font-weight:bold; margin-top:0px; margin-bottom:18px; font-family: HelveticaNeue, sans-serif; }
.article-title a { color: #9a9661; text-decoration: none; }
.article-title.with-meta {margin-bottom: 0;}
.article-meta { font-size: 13px; line-height: 20px; color: #ccc; font-weight: bold; margin-top: 0;}
.article-content { font-size: 13px; line-height: 18px; color: #444444; margin-top: 0px; margin-bottom: 18px; font-family: HelveticaNeue, sans-serif; }
.article-content a { color: #00707b; font-weight:bold; text-decoration:none; }
.article-content img { max-width: 100% }
.article-content ol, .article-content ul { margin-top:0px; margin-bottom:18px; margin-left:19px; padding:0; }
.article-content li { font-size: 13px; line-height: 18px; color: #444444; }
.article-content li a { color: #00707b; text-decoration:underline; }
.article-content p {margin-bottom: 15px;}
.footer-content-left { font-size: 12px; line-height: 15px; color: #e2e2e2; margin-top: 0px; margin-bottom: 15px; }
.footer-content-left a { color: #e7cba3; font-weight: bold; text-decoration: none; }
.footer-content-right { font-size: 11px; line-height: 16px; color: #e2e2e2; margin-top: 0px; margin-bottom: 15px; }
.footer-content-right a { color: #e7cba3; font-weight: bold; text-decoration: none; }
#footer { background-color: #043948; color: #e2e2e2; }
#footer a { color: #e7cba3; text-decoration: none; font-weight: bold; }
#permission-reminder { white-space: normal; }
#street-address { color: #e7cba3; white-space: normal; }
</style>
<!--[if gte mso 9]>
<style _tmplitem="187" >
.article-content ol, .article-content ul {
   margin: 0 0 0 24px;
   padding: 0;
   list-style-position: inside;
}
</style>
<![endif]--></head><body><table id="background-table" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tbody><tr>
		<td align="center" bgcolor="#ececec">
        	<table class="w640" style="margin:0 10px;" border="0" cellpadding="0" cellspacing="0" width="640">
            	<tbody><tr><td class="w640" height="20" width="640"></td></tr>
                
            	<tr>
                	<td class="w640" width="640">
                        <table id="top-bar" class="w640" bgcolor="#00707b" border="0" cellpadding="0" cellspacing="0" width="640">
    <tbody><tr>
        <td class="w15" width="15"></td>
        <td class="w325" align="left" valign="middle" width="350">
            <table class="w325" border="0" cellpadding="0" cellspacing="0" width="350">
                <tbody><tr><td class="w325" height="8" width="350"></td></tr>
            </tbody></table>
            <div class="header-content"><webversion>Web Version</webversion><span class="hide">&nbsp;&nbsp;|&nbsp; <preferences lang="en">Update preferences</preferences>&nbsp;&nbsp;|&nbsp; <unsubscribe>Unsubscribe</unsubscribe></span></div>
            <table class="w325" border="0" cellpadding="0" cellspacing="0" width="350">
                <tbody><tr><td class="w325" height="8" width="350"></td></tr>
            </tbody></table>
        </td>
        <td class="w30" width="30"></td>
        <td class="w255" align="right" valign="middle" width="255">
            <table class="w255" border="0" cellpadding="0" cellspacing="0" width="255">
                <tbody><tr><td class="w255" height="8" width="255"></td></tr>
            </tbody></table>
            <table border="0" cellpadding="0" cellspacing="0">
    <tbody><tr>
        
        <td valign="middle"><fblike><img src="https://img.createsend1.com/img/templatebuilder/like-glyph.png" alt="Facebook icon"="" height="14" border="0" width="8"></fblike></td>
        <td width="3"></td>
        <td valign="middle"><div class="header-content"><fblike>Like</fblike></div></td>
        
        
        <td class="w10" width="10"></td>
        <td valign="middle"><tweet><img src="https://img.createsend1.com/img/templatebuilder/tweet-glyph.png" alt="Twitter icon"="" height="13" border="0" width="17"></tweet></td>
        <td width="3"></td>
        <td valign="middle"><div class="header-content"><tweet>Tweet</tweet></div></td>
        
        
        <td class="w10" width="10"></td>
        <td valign="middle"><forwardtoafriend lang="en"><img src="https://img.createsend1.com/img/templatebuilder/forward-glyph.png" alt="Forward icon"="" height="14" border="0" width="19"></forwardtoafriend></td>
        <td width="3"></td>
        <td valign="middle"><div class="header-content"><forwardtoafriend lang="en">Forward</forwardtoafriend></div></td>
        
    </tr>
</tbody></table>
            <table class="w255" border="0" cellpadding="0" cellspacing="0" width="255">
                <tbody><tr><td class="w255" height="8" width="255"></td></tr>
            </tbody></table>
        </td>
        <td class="w15" width="15"></td>
    </tr>
</tbody></table>
                        
                    </td>
                </tr>
                <tr>
                <td id="header" class="w640" align="center" bgcolor="#00707b" width="640">
    
    <table class="w640" border="0" cellpadding="0" cellspacing="0" width="640">
        <tbody><tr><td class="w30" width="30"></td><td class="w580" height="30" width="580"></td><td class="w30" width="30"></td></tr>
        <tr>
            <td class="w30" width="30"></td>
            <td class="w580" width="580">
                <div id="headline" align="center">
                    <p>
                        <strong><singleline label="Title">We can send HTML mail too!!</singleline></strong>
                    </p>
                </div>
            </td>
            <td class="w30" width="30"></td>
        </tr>
    </tbody></table>
    
    
</td>
                </tr>
                
                <tr><td class="w640" height="30" bgcolor="#ffffff" width="640"></td></tr>
                <tr id="simple-content-row"><td class="w640" bgcolor="#ffffff" width="640">
    <table class="w640" border="0" cellpadding="0" cellspacing="0" width="640">
        <tbody><tr>
            <td class="w30" width="30"></td>
            <td class="w580" width="580">
                <repeater>
                    
                    <layout label="Text only">
                        <table class="w580" border="0" cellpadding="0" cellspacing="0" width="580">
                            <tbody><tr>
                                <td class="w580" width="580">
                                    <p class="article-title" align="left"><singleline label="Title">Add a title</singleline></p>
                                    <div class="article-content" align="left">
                                        <multiline label="Description">Enter your description</multiline>
                                    </div>
                                </td>
                            </tr>
                            <tr><td class="w580" height="10" width="580"></td></tr>
                        </tbody></table>
                    </layout>
                                        
                    
                    <layout label="Text with full-width image">
                        <table class="w580" border="0" cellpadding="0" cellspacing="0" width="580">
                            <tbody><tr>
                                <td class="w580" width="580">
                                    <p class="article-title" align="left"><singleline label="Title">Add a title</singleline></p>
                                </td>
                            </tr>
                            <tr>
                                <td class="w580" width="580"><img editable="true" label="Image" class="w580" border="0" width="580"></td>
                            </tr>
                            <tr><td class="w580" height="15" width="580"></td></tr>
                            <tr>
                                <td class="w580" width="580">
                                    <div class="article-content" align="left">
                                        <multiline label="Description">Enter your description</multiline>
                                    </div>
                                </td>
                            </tr>
                            <tr><td class="w580" height="10" width="580"></td></tr>
                        </tbody></table>
                    </layout>
                                        
                    
                    <layout label="Text with right-aligned image">
                        <table class="w580" border="0" cellpadding="0" cellspacing="0" width="580">
                            <tbody><tr>
                                <td class="w580" width="580">
                                    <p class="article-title" align="left"><singleline label="Title">Add a title</singleline></p>
                                    <table align="right" border="0" cellpadding="0" cellspacing="0">
                                        <tbody><tr>
                                            <td class="w30" width="15"></td>
                                            <td><img editable="true" label="Image" class="w300" border="0" width="300"></td>
                                        </tr>
                                        <tr><td class="w30" height="5" width="15"></td><td></td></tr>
                                    </tbody></table>
                                    <div class="article-content" align="left">
                                        <multiline label="Description">Enter your description</multiline>
                                    </div>
                                </td>
                            </tr>
                            <tr><td class="w580" height="10" width="580"></td></tr>
                        </tbody></table>
                    </layout>
                                        
                    
                    <layout label="Text with left-aligned image">
                        <table class="w580" border="0" cellpadding="0" cellspacing="0" width="580">
                            <tbody><tr>
                                <td class="w580" width="580">
                                    <p class="article-title" align="left"><singleline label="Title">Add a title</singleline></p>
                                    <table align="left" border="0" cellpadding="0" cellspacing="0">
                                        <tbody><tr>
                                            <td><img editable="true" label="Image" class="w300" border="0" width="300"></td>
                                            <td class="w30" width="15"></td>
                                        </tr>
                                        <tr><td></td><td class="w30" height="5" width="15"></td></tr>
                                    </tbody></table>
                                    <div class="article-content" align="left">
                                        <multiline label="Description">Enter your description</multiline>
                                    </div>
                                </td>
                            </tr>
                            <tr><td class="w580" height="10" width="580"></td></tr>
                        </tbody></table>
                    </layout>
                                                                                
                    
                    <layout label="Two columns">
                        <table class="w580" border="0" cellpadding="0" cellspacing="0" width="580">
                            <tbody><tr>
                                <td class="w275" valign="top" width="275">
                                    <table class="w275" border="0" cellpadding="0" cellspacing="0" width="275">
                                        <tbody><tr>
                                            <td class="w275" width="275">
                                                <p class="article-title" align="left"><singleline label="Title">Add a title</singleline></p>
                                                <div class="article-content" align="left">
                                                    <multiline label="Description">Enter your description</multiline>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr><td class="w275" height="10" width="275"></td></tr>
                                    </tbody></table>
                                </td>
                                <td class="w30" width="30"></td>
                                <td class="w275" valign="top" width="275">
                                    <table class="w275" border="0" cellpadding="0" cellspacing="0" width="275">
                                        <tbody><tr>
                                            <td class="w275" width="275">
                                                <p class="article-title" align="left"><singleline label="Title">Add a title</singleline></p>
                                                <div class="article-content" align="left">
                                                    <multiline label="Description">Enter your description</multiline>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr><td class="w275" height="10" width="275"></td></tr>
                                    </tbody></table>
                                </td>
                            </tr>
                        </tbody></table>
                    </layout>
                                        
                                        
                    
                    <layout label="Image gallery">
                        <table class="w580" border="0" cellpadding="0" cellspacing="0" width="580">
                            <tbody><tr>
                                <td class="w180" valign="top" width="180">
                                    <table class="w180" border="0" cellpadding="0" cellspacing="0" width="180">
                                        <tbody><tr>
                                            <td class="w180" width="180"><img editable="true" label="Image" class="w180" border="0" width="180"></td>
                                        </tr>
                                        <tr><td class="w180" height="10" width="180"></td></tr>
                                        <tr>
                                            <td class="w180" width="180">
                                                <div class="article-content" align="left">
                                                    <multiline label="Description">Enter your description</multiline>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr><td class="w180" height="10" width="180"></td></tr>
                                    </tbody></table>
                                </td>
                                <td width="20"></td>
                                <td class="w180" valign="top" width="180">
                                    <table class="w180" border="0" cellpadding="0" cellspacing="0" width="180">
                                        <tbody><tr>
                                            <td class="w180" width="180"><img editable="true" label="Image" class="w180" border="0" width="180"></td>
                                        </tr>
                                        <tr><td class="w180" height="10" width="180"></td></tr>
                                        <tr>
                                            <td class="w180" width="180">
                                                <div class="article-content" align="left">
                                                    <multiline label="Description">Enter your description</multiline>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr><td class="w180" height="10" width="180"></td></tr>
                                    </tbody></table>
                                </td>
                                <td width="20"></td>
                                <td class="w180" valign="top" width="180">
                                    <table class="w180" border="0" cellpadding="0" cellspacing="0" width="180">
                                        <tbody><tr>
                                            <td class="w180" width="180"><img editable="true" label="Image" class="w180" border="0" width="180"></td>
                                        </tr>
                                        <tr><td class="w180" height="10" width="180"></td></tr>
                                        <tr>
                                            <td class="w180" width="180">
                                                <div class="article-content" align="left">
                                                    <multiline label="Description">Enter your description</multiline>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr><td class="w180" height="10" width="180"></td></tr>
                                    </tbody></table>
                                </td>
                            </tr>
                        </tbody></table>
                    </layout>
                </repeater>
            </td>
            <td class="w30" width="30"></td>
        </tr>
    </tbody></table>
</td></tr>
                <tr><td class="w640" height="15" bgcolor="#ffffff" width="640"></td></tr>
                
                <tr>
                <td class="w640" width="640">
    <table id="footer" class="w640" bgcolor="#043948" border="0" cellpadding="0" cellspacing="0" width="640">
        <tbody><tr><td class="w30" width="30"></td><td class="w580 h0" height="30" width="360"></td><td class="w0" width="60"></td><td class="w0" width="160"></td><td class="w30" width="30"></td></tr>
        <tr>
            <td class="w30" width="30"></td>
            <td class="w580" valign="top" width="360">
            <span class="hide"><p id="permission-reminder" class="footer-content-left" align="left"></p></span>
            <p class="footer-content-left" align="left"><preferences lang="en">Edit your subscription</preferences> | <unsubscribe>Unsubscribe</unsubscribe></p>
            </td>
            <td class="hide w0" width="60"></td>
            <td class="hide w0" valign="top" width="160">
            <p id="street-address" class="footer-content-right" align="right"></p>
            </td>
            <td class="w30" width="30"></td>
        </tr>
        <tr><td class="w30" width="30"></td><td class="w580 h0" height="15" width="360"></td><td class="w0" width="60"></td><td class="w0" width="160"></td><td class="w30" width="30"></td></tr>
    </tbody></table>
</td>
                </tr>
                <tr><td class="w640" height="60" width="640"></td></tr>
            </tbody></table>
        </td>
	</tr>
</tbody></table></body></html>
EOF;
		$this->assertTrue(MailSender::sendEmail("claramoore@speakeasy.net,
				 tuanvo@uw.edu,
				dannych@uw.edu,
				ctjong@uw.edu,
				ynamara@cs.washington.edu,
				rsihongbing@gmail.com", "HTML mail", $message, true));
	}
}

?>