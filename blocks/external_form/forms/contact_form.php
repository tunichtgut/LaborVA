<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));
?>

<style>
#contact_form form {
border: 0px;
}

#contact_form form div {
clear: both;
margin-bottom: 1px;
padding-bottom: 5px;
}

#contact_form form label {
display: block;
float: left;
width: 80px;
padding-left: 22px;
font-weight: bold;
}

#contact_form form img {
text-align: right;
}

#contact_form form input, textarea {
border: none; /*1px solid #ffd10d;*/
background-color: #f2f2f2;
}

#contact_form form input:focus, textarea:focus {
border: none; /*1px solid #ff735e;*/
background-color: #f2f2f2;
}

#submitdiv {
margin-left: 102px;
margin-bottom: 1px;
padding-bottom: 5px;
}

#contact_form form label.required {
background-repeat: no-repeat;
background-position: 3px 0px;
padding-bottom: 1px;
color: #191919;
}

#contact_form form label.problem {
background-repeat: no-repeat;
background-position: 3px 0px;
padding-bottom: 1px;
color: #ff735e;
}

#contact_form form label.completed {
background-repeat: no-repeat;
background-position: 3px 0px;
padding-bottom: 1px;
color: #000000;
}

#error {
color: #ff735e;
font-weight: bold;
font-size: 8pt;
}

#noerror {
color: #777777;
font-weight: bold;
font-size: 8pt;
}
</style>

<script language="javascript">
function getLabelForId(id) {
    var label, labels = document.getElementsByTagName('label');
    for (var i = 0; (label = labels[i]); i++) {
        if (label.htmlFor == id) {
            return label;
        }
    }
    return false;
}
function check(id) {
    var formfield = document.getElementById(id);
    var label = getLabelForId(id);
    if (formfield.value.length == 0) {
        label.className = 'problem';
				formfield.style.background = "#ffa796";
    } 
		else {
        label.className = 'completed';
				formfield.style.background = "#f2f2f2";
    }
}
addEvent(window, 'load', function() {
    var input;
    var inputs = document.getElementsByTagName('input');
    for (var i = 0; (input = inputs[i]); i++) {
        addEvent(input, 'focus', oninputfocus);
        addEvent(input, 'blur', oninputblur);
    }
    var textareas = document.getElementsByTagName('textarea');
    for (var i = 0; (textarea = textareas[i]); i++) {
        addEvent(textarea, 'focus', oninputfocus);
        addEvent(textarea, 'blur', oninputblur);
    }
});
function oninputfocus(e) {
    if (typeof e == 'undefined') {
        var e = window.event;
    }
    var source;
    if (typeof e.target != 'undefined') {
        source = e.target;
    } 
		else if (typeof e.srcElement != 'undefined') {
        source = e.srcElement;
    } 
		else {
        return;
    }
    source.style.border='1px solid #ffd10d';
}
function oninputblur(e) {
    if (typeof e == 'undefined') {
        var e = window.event;
    }
    var source;
    if (typeof e.target != 'undefined') {
        source = e.target;
    }
		else if (typeof e.srcElement != 'undefined') {
        source = e.srcElement;
    }
		else {
        return;
    }
    source.style.border='none';
}
function addEvent(obj, evType, fn) {
    if (obj.addEventListener) {
        obj.addEventListener(evType, fn, true);
        return true;
    } 
		else if (obj.attachEvent) {
        var r = obj.attachEvent("on"+evType, fn);
        return r;
    } 
		else {
        return false;
    }
}
function checkField(field, msg, max) {
   min = 2;
   if (!field.value || field.value.length < min || field.value.length > max) {
	    alert(msg);
			field.focus();
			field.select();
			field.style.background = "#ffa796";
			return false;
	 }
   return true;
}
function checkEmail(field, msg, max) {
   min = 8;
   var re_mail = /^([_a-zA-Z0-9-]+)(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+)(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,6})$/;
   if (!re_mail.test(field.value) || field.value.length < min || field.value.length > max) {
	   alert(msg);
		 field.focus();
		 field.select();
		 field.style.background = "#ffa796";
		 return false;
	 }
   return true;
}
</script>

<?php
$form = Loader::helper('form');

// Analise entered data after Submit button has been clicked
if(isset($no_error_msg)) { ?>
	<div id="noerror">
	<?php echo $no_error_msg; ?>
	</div>
<?php 
}

elseif(isset($errors)) { ?> 
	<div id="error">
	<ul class="errors"> 
	<?php foreach($errors as $error){ ?> 
		<li><?php echo $error; ?></li> 
	<?php } ?>  
	</ul>
	</div>
<?php 
	if(isset($error_msg)) {
		echo $error_msg;
	}
} ?>

<div table="contact_form">
	<form action="<?php echo $this->action('submit_form')?>" 
		method="post" 
		onsubmit="return (checkField(this.name, 'Bitte geben Sie Ihren Namen ein.\n(2-70 Zeichen)', 70) && 
		checkEmail(this.email, 'Bitte geben Sie eine gültige E-Mail Adresse an.', 100) && 
		checkField(this.ccmCaptchaCode, 'Bitte geben Sie den Sicherheitscode aus dem Bild ein.\n(6 Zeichen)', 6) && 
		checkField(this.message, 'Bitte geben Sie eine Nachricht mit mehr als zwei und weniger als 3000 Buchstaben ein.\n', 3000));" >
		<tr>	
			<td><label for="name" class="required">Ihr Name:</label></td>
			<td><input type="text" id="name" name="name" value="" maxlength="70" size="40" onblur="check('name');" /></td>
		</tr><br />
		<tr>	
			<td><label for="email" class="required">Ihre E-Mail Adresse:</label> </td>
			<td><input type="text" id="email" name="email" value="" maxlength="100" size="40" onblur="check('email');" /></td>
		</tr><br />
		<tr>	
			<td><label for="message" class="required">Ihre Frage oder Nachricht:</label> </td>
			<td><textarea id="message" name="message" value="" cols="60" rows="10" onblur="check('message');"></textarea></td>
		</tr><br />
		<tr>
			<td colspan="2">
				<?php
				$captcha = Loader::helper('validation/captcha');
				$captcha->display();
				?>
			</td>
		</tr><br />
		<tr>	
			<td><label for="ccmCaptchaCode" class="required">Sicherheitscode:</label></td>
			<td><input type="text" id="ccmCaptchaCode" name="ccmCaptchaCode" value="" maxlength="6" size="10" onblur="check('ccmCaptchaCode');" /></td>
		</tr><br />
		<tr>
			<td colspan="2"><input class="btn" type="submit" name="submit" value="Abschicken" /> </td>
		</tr><br />
		<tr>
			<td colspan="2"><input type="hidden" value="<?php echo $_SESSION['stamp'];?>" name="stamp" /></td>
		</tr>
	</form>
</table>