/*** Enable or disable submit button depending on the Terms & Condition checkbox. ***/
function SubmitButtonToggle() {
    var isDisabled = document.forms.registrationform.registerBtn.disabled;
    document.forms.registrationform.registerBtn.disabled = isDisabled ? false : true;
}

/***
 * Check the country field and change the caounty field accordingly.
 * If country id = 80 (Ireland) than insert county list else enable input field.
 ***/
/*function checkCountry() {

    // Value that comes from the form (Select country drop-down)
    var selectedCountry = _("country").value;

    // div that creates space for return code
    var countyStatus = _("countyStatus");
    alert(selectedCountry);
    if (selectedCountry == '0') {

        // If no country selected disable county field
        _("county").disabled = true;

    }else{

        var ajax = ajaxObj("POST", "app/inc/reg.country.inc.php");

        ajax.onreadystatechange = function () {

            if (ajaxReturn(ajax) == true) {

                if (ajax.responseText == true) {
                    _("countyStatus").innerHTML = '<label for=\"county\">County:</label><select id=\"county\" name=\"county\" class="input-block-level"><option value=\"\">Select county</option><?php echo $county_list; ?></select><div class=\"reg-status\" id=\"countyInfo\"></div>';
                }else{
                    _("countyStatus").innerHTML = '<label class=\"control-label\" for=\"county\">County:</label><input class=\"input-block-level\" type=\"text\" id=\"county\" name=\"county\" placeholder=\"Enter county name\"/><div class=\"reg-status\" id=\"countyInfo\"></div>';
                }

            }

        };

        ajax.send("selectedCountry=" + selectedCountry);

    }
}*/


function validateFormFields() {

    // Email Address
    var email1 = _("email1").value;
    var email2 = _("email2").value;

    // Password
    var password1 = _("password1").value;
    var password2 = _("password2").value;

    // Name & Address
    var fname = _("fname").value;
    var lname = _("lname").value;
    var address1 = _("address1").value;
    var address2 = _("address2").value;
    var country = _("country").value;
    var county = _("county").value;
    var town = _("town").value;
    var postal_code = _("postal_code").value;

    //Mobile phone
    var mobile = _("mobile").value;

    // Date of Birth
    var dob = _("dob").value;

    // Gender
    var gender = _("gender").value;
    //$('div.btn-group[data-toggle-name]').val();
    //$('input[name=gender]:checked').val();

    // Features
    var checkBoxMail = _("checkBoxMail").value;
    var checkBoxTxt = _("checkBoxTxt").value;

    // Terms & Conditions
    var checkBoxTerms = _("checkBoxTerms").value;

    //alert("mail1: " + "\n" + email1 + "\n" + "mail2: " + "\n" + email2 + "\n" + password1 + "\n" + password2 + "\n" + fname + "\n" + lname + "\n" + address1 + "\n" + address2 + "\n" + country + "\n" + county + "\n" + town + "\n" + postal_code + "\n" + mobile + "\n" + dob + "\n" + gender + "\n" + checkBoxMail + "\n" + checkBoxTxt + "\n" + checkBoxTerms);

    // INFO BOXES
    var status = _("status");

    var email1Info = _("email1Info");
    var email2Info = _("email2Info");
    var emailInfo = _("emailInfo");

    var password1Info = _("password1Info");
    var password2Info = _("password2Info");
    var passwordInfo = _("passwordInfo");

    var fnameInfo = _("fnameInfo");
    var lnameInfo = _("lnameInfo");
    var nameInfo = _("nameInfo");

    var address1Info = _("address1Info");
    var address2Info = _("address2Info");
    var addressInfo = _("addressInfo");

    var countryInfo = _("countryInfo");
    var countyInfo = _("countyInfo");
    var countryCountyInfo = _("countryCountyInfo");

    var townInfo = _("townInfo");
    var postalInfo = _("postalInfo");
    var townPostInfo = _("townPostInfo");

    var mobileInfo = _("mobileInfo");
    var mobilePhoneInfo = _("mobilePhoneInfo");

    var dobInfo = _("dobInfo");
    var genderInfo = _("genderInfo");
    var dobGenderInfo = _("dobGenderInfo");

    var termsInfo = _("termsInfo");


    if (email1 == "" || email2 == "" || password1 == "" || password2 == "" || fname == "" || lname == "" || address1 == "" || address2 == "" || country == "" || country == 0 || county == "" || county == 0 || town == "" || postal_code == "" || mobile == "" || dob == "" || gender == "" || checkBoxTerms == "") {

        // EMAIL VALIDATION
        if (email1 == "") {
            document.getElementById('email1').style.border = '1px solid red';
            email1Info.style.display = 'block';
            email1Info.innerHTML = "Enter your email address!";
            status.innerHTML = "Fill out all of the form data!";
        }
        if (email2 == "") {
            document.getElementById('email2').style.border = '1px solid red';
            email2Info.style.display = 'block';
            email2Info.innerHTML = "Confirm email address!";
            status.innerHTML = "Fill out all of the form data!";
        }
        if (email1 != email2) {
            document.getElementById('email1').style.border = '1px solid red';
            document.getElementById('email2').style.border = '1px solid red';
            emailInfo.style.display = 'block';
            emailInfo.innerHTML = "Email addresses don't match!";
        }
        // PASSWORD VALIDATION
        if (password1 == "") {
            document.getElementById('password1').style.border = '1px solid red';
            password1Info.style.display = 'block';
            password1Info.innerHTML = "Enter password!";
            status.innerHTML = "Fill out all of the form data!";
        }
        if (password2 == "") {
            document.getElementById('password2').style.border = '1px solid red';
            password2Info.style.display = 'block';
            password2Info.innerHTML = "Confirm password!";
            status.innerHTML = "Fill out all of the form data!";
        }
        if (password1 != password2) {
            document.getElementById('password1').style.border = '1px solid red';
            document.getElementById('password2').style.border = '1px solid red';
            passwordInfo.style.display = 'block';
            passwordInfo.innerHTML = "Passwords don't match!";
        }

        // NAME VALIDATION
        if (fname == "") {
            document.getElementById('fname').style.border = '1px solid red';
            fnameInfo.style.display = 'block';
            fnameInfo.innerHTML = "Enter first name!";
            status.innerHTML = "Fill out all of the form data!";
        }
        if (lname == "") {
            document.getElementById('lname').style.border = '1px solid red';
            lnameInfo.style.display = 'block';
            lnameInfo.innerHTML = "Enter last name!";
            status.innerHTML = "Fill out all of the form data!";
        }

        // ADDRESS VALIDATION
        if (address1 == "") {
            document.getElementById('address1').style.border = '1px solid red';
            address1Info.style.display = 'block';
            address1Info.innerHTML = "Enter address!";
            status.innerHTML = "Fill out all of the form data!";
        }
        if(address2 == ""){
         document.getElementById('address2').style.border= '1px solid red';
         address2Info.style.display = 'block';
         address2Info.innerHTML = "Enter last name!";
         status.innerHTML = "Fill out all of the form data!";
         }

        // COUNTRY VALIDATION
        if (country == "" || country == 0) {
            document.getElementById('country').style.border = '1px solid red';
            countryInfo.style.display = 'block';
            countryInfo.innerHTML = "Select country!";
            status.innerHTML = "Fill out all of the form data!";
        }

        // COUNTY VALIDATION
        if (county == "" || county == 0) {
            document.getElementById('county').style.border = '1px solid red';
            countyInfo.style.display = 'block';
            countyInfo.innerHTML = "Select (enter) county!";
            status.innerHTML = "Fill out all of the form data!";
        }

        // TOWN VALIDATION
        if (town == "") {
            document.getElementById('town').style.border = '1px solid red';
            townInfo.style.display = 'block';
            townInfo.innerHTML = "Enter town name!";
            status.innerHTML = "Fill out all of the form data!";
        }

        // MOBILE PHONE VALIDATION
        if (mobile == "") {
            document.getElementById('mobile').style.border = '1px solid red';
            mobileInfo.style.display = 'block';
            mobileInfo.innerHTML = "Enter mobile phone number!";
            status.innerHTML = "Fill out all of the form data!";
        }

        // POSTAL CODE VALIDATION
        if (postal_code == "") {
            document.getElementById('postal_code').style.border = '1px solid red';
            postalInfo.style.display = 'block';
            postalInfo.innerHTML = "Enter postal code!";
            status.innerHTML = "Fill out all of the form data!";
        }

        // DATE OF BIRTH VALIDATION
        if (dob == "") {
            document.getElementById('dob').style.border = '1px solid red';
            dobInfo.style.display = 'block';
            dobInfo.innerHTML = "Enter date of birth!";
            status.innerHTML = "Fill out all of the form data!";
        }

        // GENDER VALIDATION
        if (gender == "") {
            document.getElementById('gender-group').style.border = '1px solid red';
            genderInfo.style.display = 'block';
            genderInfo.innerHTML = "Select gender!";
            status.innerHTML = "Fill out all of the form data!";
        }

        // TERMS & CONDITION VALIDATION
        if (checkBoxTerms == "") {
            document.getElementById('checkBoxTerms').style.border = '1px solid red';
            termsInfo.style.display = 'block';
            termsInfo.innerHTML = "You have to agree to the Terms &amp; Conditions to continue!";
            status.innerHTML = "Fill out all of the form data!";
        }
    } else {
        signup();
    }
}
/*** Enable or disable submit button on Reset click depending on the current state. ***/
function resetButtonCheckBox() {
    var isChecked = document.forms.registrationform.reset.checked;
    document.forms.registrationform.registerBtn.disabled = isChecked ? false : true;

    // INFO BOXES
    var status = _("status");

    var email1Info = _("email1Info");
    var email2Info = _("email2Info");
    var emailInfo = _("emailInfo");

    var password1Info = _("password1Info");
    var password2Info = _("password2Info");
    var passwordInfo = _("passwordInfo");

    var fnameInfo = _("fnameInfo");
    var lnameInfo = _("lnameInfo");
    var nameInfo = _("nameInfo");

    var address1Info = _("address1Info");
    var address2Info = _("address2Info");
    var addressInfo = _("addressInfo");

    var countryInfo = _("countryInfo");
    var countyInfo = _("countyInfo");
    var countryCountyInfo = _("countryCountyInfo");

    var townInfo = _("townInfo");
    var postalInfo = _("postalInfo");
    var townPostInfo = _("townPostInfo");

    var mobileInfo = _("mobileInfo");

    var dobInfo = _("dobInfo");
    var genderInfo = _("genderInfo");
    var dobGenderInfo = _("dobGenderInfo");

    var termsInfo = _("termsInfo");

    document.getElementById('email1').style.border = '1px solid #bcbcbc';
    email1Info.style.display = 'none';
    email1Info.innerHTML = "Enter your email address!";

    document.getElementById('email2').style.border = '1px solid #bcbcbc';
    email2Info.style.display = 'none';

    document.getElementById('email1').style.border = '1px solid #bcbcbc';
    document.getElementById('email2').style.border = '1px solid #bcbcbc';
    emailInfo.style.display = 'none';

    document.getElementById('password1').style.border = '1px solid #bcbcbc';
    password1Info.style.display = 'none';

    document.getElementById('password2').style.border = '1px solid #bcbcbc';
    password2Info.style.display = 'none';

    document.getElementById('password1').style.border = '1px solid #bcbcbc';
    document.getElementById('password2').style.border = '1px solid #bcbcbc';
    passwordInfo.style.display = 'none';

    document.getElementById('fname').style.border = '1px solid #bcbcbc';
    fnameInfo.style.display = 'none';

    document.getElementById('lname').style.border = '1px solid #bcbcbc';
    lnameInfo.style.display = 'none';

    document.getElementById('address1').style.border = '1px solid #bcbcbc';
    address1Info.style.display = 'none';

    /*
     document.getElementById('address2').style.border= '1px solid #bcbcbc';
     address2Info.style.display = 'none';
     */

    document.getElementById('country').style.border = '1px solid #bcbcbc';
    countryInfo.style.display = 'none';

    document.getElementById('county').style.border = '1px solid #bcbcbc';
    countyInfo.style.display = 'none';

    document.getElementById('town').style.border = '1px solid #bcbcbc';
    townInfo.style.display = 'none';

    document.getElementById('postal_code').style.border = '1px solid #bcbcbc';
    postalInfo.style.display = 'none';

    document.getElementById('mobile').style.border = '1px solid #bcbcbc';
    mobileInfo.style.display = 'none';

    document.getElementById('dob').style.border = '1px solid #bcbcbc';
    dobInfo.style.display = 'none';

    document.getElementById('gender-group').style.border = '1px solid #bcbcbc';
    genderInfo.style.display = 'none';

    document.getElementById('checkBoxTerms').style.border = '1px solid #bcbcbc';
    termsInfo.style.display = 'none';

}


function restrict(elem) {
    var tf = _(elem);
    var rx = new RegExp;
    if (elem == "email") {
        rx = /[' "]/gi;
    } else if (elem == "username") {
        rx = /[^a-z0-9]/gi;
    }
    tf.value = tf.value.replace(rx, "");
}

function emptyElement(x) {
    _(x).innerHTML = "";
}

function checkfname() {

    var fnameInfo = _("fnameInfo");

    var fname = _("fname").value;

    if (fname != "") {
        password2Info.style.display = 'block';
        _("password2Info").innerHTML = 'Confirm password!';
    } else {
        passwordInfo.style.display = 'block';
        _("passwordInfo").innerHTML = 'OK';
    }
}
function checklname() {

    var u = _("lname").value;
    if (u != "") {
        _("lnameInfo").innerHTML = '<img src="img/spinner.png" alt="checking" /> Checking...';
        var ajax = ajaxObj("POST", "app/inc/registrationFormValidation.php");
        ajax.onreadystatechange = function () {
            if (ajaxReturn(ajax) == true) {
                _("lnameInfo").innerHTML = ajax.responseText;
            }
        };
        ajax.send("lname=" + u);
    }
}

function checkpassword() {

    var password1Info = _("password1Info");
    var password2Info = _("password2Info");
    var passwordInfo = _("passwordInfo");

    var p1 = _("password1").value;
    var p2 = _("password2").value;

    if (p2 != p1) {
        passwordInfo.style.display = 'block';
        _("passwordInfo").innerHTML = 'Passwords do not match!';
    } else if(p1 == ""){
        password1Info.style.display = 'block';
        _("password1Info").innerHTML = 'Enter password!';
    } else if(p2 == ""){
        password2Info.style.display = 'block';
        _("password2Info").innerHTML = 'Confirm password!';
    } else {
        passwordInfo.style.display = 'block';
        _("passwordInfo").innerHTML = '<strong style="color:#009900;">OK</strong>';
    }
}

function checkemail() {

    var email1Info = _("email1Info");
    var emailInfo = _("emailInfo");

    var e = _("email1").value;

    //alert(e);

    if (e != "") {
        _("email1Info").innerHTML = '<img src="img/spinner.png" alt="checking" /> Checking...';
        var ajax = ajaxObj("POST", "app/inc/registrationFormValidation.php");
        ajax.onreadystatechange = function () {
            if (ajaxReturn(ajax) == true) {
                email1Info.style.display = 'block';
                emailInfo.style.display = 'block';
                _("email1Info").innerHTML = ajax.responseText;
            }
        };
        ajax.send("emailcheck=" + e);
    }
}
function checkemails() {

    var emailInfo = _("emailInfo");

    var e1 = _("email1").value;
    var e2 = _("email2").value;

    if (e1 != e2) {
        emailInfo.style.display = 'block';
        _("emailInfo").innerHTML = 'Emails do not match!';
    } else {
        emailInfo.style.display = 'block';
        _("emailInfo").innerHTML = '<strong style="color:#009900;">OK</strong>';
    }
}
function signup() {

    var email1 = _("email1").value;
    var email2 = _("email2").value;
    var password1 = _("password1").value;
    var password2 = _("password2").value;
    var fname = _("fname").value;
    var lname = _("lname").value;
    var address1 = _("address1").value;
    var address2 = _("address2").value;
    var country = _("country").value;
    var county = _("county").value;
    var town = _("town").value;
    var postal_code = _("postal_code").value;
    var mobile = _("mobile").value;
    var dob = _("dob").value;
    var gender = _("gender").value;
    var checkBoxMail = _("checkBoxMail").value;
    var checkBoxTxt = _("checkBoxTxt").value;
    var checkBoxTerms = _("checkBoxTerms").value;

    // INFO BOXES
    var email1Info = _("email1Info");
    var email2Info = _("email2Info");
    var emailInfo = _("emailInfo");
    var password1Info = _("password1Info");
    var password2Info = _("password2Info");
    var passwordInfo = _("passwordInfo");
    var fnameInfo = _("fnameInfo");
    var lnameInfo = _("lnameInfo");
    var nameInfo = _("nameInfo");
    var address1Info = _("address1Info");
    var address2Info = _("address2Info");
    var addressInfo = _("addressInfo");
    var countryInfo = _("countryInfo");
    var countyInfo = _("countyInfo");
    var countryCountyInfo = _("countryCountyInfo");
    var townInfo = _("townInfo");
    var postalInfo = _("postalInfo");
    var townPostInfo = _("townPostInfo");
    var mobileInfo = _("mobileInfo");
    var dobInfo = _("dobInfo");
    var genderInfo = _("genderInfo");
    var dobGenderInfo = _("dobGenderInfo");
    var termsInfo = _("termsInfo");

    //alert(email1 + "\n" + email2 + "\n" + password1 + "\n" + password2 + "\n" + fname + "\n" + lname + "\n" + address1 + "\n" + address2 + "\n" + country + "\n" + county + "\n" + town + "\n" + postal_code + "\n" + mobile + "\n" + dob + "\n" + gender + "\n" + checkBoxMail + "\n" + checkBoxTxt + "\n" + checkBoxTerms);

    var status = _("status");
    if(email1 == "" || email2 == "" || password1 == "" || password2 == "" || fname == "" || lname == "" || address1 == "" || country == "" || country == 0 || county == "" || county == 0 || town == "" || postal_code == "" || mobile == "" || dob == "" || gender == "" || checkBoxTerms == ""){

        // EMAIL VALIDATION
        if (email1 == "") {
            document.getElementById('email1').style.border = '1px solid red';
            email1Info.style.display = 'block';
            email1Info.innerHTML = "Enter your email address!";
            status.innerHTML = "Fill out all of the form data!";
        }
        if (email2 == "") {
            document.getElementById('email2').style.border = '1px solid red';
            email2Info.style.display = 'block';
            email2Info.innerHTML = "Confirm email address!";
            status.innerHTML = "Fill out all of the form data!";
        }
        if (email1 != email2) {
            document.getElementById('email1').style.border = '1px solid red';
            document.getElementById('email2').style.border = '1px solid red';
            emailInfo.style.display = 'block';
            emailInfo.innerHTML = "Email addresses don't match!";
        }
        // PASSWORD VALIDATION
        if (password1 == "") {
            document.getElementById('password1').style.border = '1px solid red';
            password1Info.style.display = 'block';
            password1Info.innerHTML = "Enter password!";
            status.innerHTML = "Fill out all of the form data!";
        }
        if (password2 == "") {
            document.getElementById('password2').style.border = '1px solid red';
            password2Info.style.display = 'block';
            password2Info.innerHTML = "Confirm password!";
            status.innerHTML = "Fill out all of the form data!";
        }
        if (password1 != password2) {
            document.getElementById('password1').style.border = '1px solid red';
            document.getElementById('password2').style.border = '1px solid red';
            passwordInfo.style.display = 'block';
            passwordInfo.innerHTML = "Passwords don't match!";
        }

        // NAME VALIDATION
        if (fname == "") {
            document.getElementById('fname').style.border = '1px solid red';
            fnameInfo.style.display = 'block';
            fnameInfo.innerHTML = "Enter first name!";
            status.innerHTML = "Fill out all of the form data!";
        }
        if (lname == "") {
            document.getElementById('lname').style.border = '1px solid red';
            lnameInfo.style.display = 'block';
            lnameInfo.innerHTML = "Enter last name!";
            status.innerHTML = "Fill out all of the form data!";
        }

        // ADDRESS VALIDATION
        if (address1 == "") {
            document.getElementById('address1').style.border = '1px solid red';
            address1Info.style.display = 'block';
            address1Info.innerHTML = "Enter address!";
            status.innerHTML = "Fill out all of the form data!";
        }
        /*if(address2 == ""){
         document.getElementById('address2').style.border= '1px solid red';
         address2Info.style.display = 'block';
         address2Info.innerHTML = "Enter last name!";
         status.innerHTML = "Fill out all of the form data!";
         }*/

        // COUNTRY VALIDATION
        if (country == "" || country == 0) {
            document.getElementById('country').style.border = '1px solid red';
            countryInfo.style.display = 'block';
            countryInfo.innerHTML = "Select country!";
            status.innerHTML = "Fill out all of the form data!";
        }

        // COUNTY VALIDATION
        if (county == "" || county == 0) {
            document.getElementById('county').style.border = '1px solid red';
            countyInfo.style.display = 'block';
            countyInfo.innerHTML = "Select (enter) county!";
            status.innerHTML = "Fill out all of the form data!";
        }

        // TOWN VALIDATION
        if (town == "") {
            document.getElementById('town').style.border = '1px solid red';
            townInfo.style.display = 'block';
            townInfo.innerHTML = "Enter town name!";
            status.innerHTML = "Fill out all of the form data!";
        }

        // MOBILE PHONE VALIDATION
        if (mobile == "") {
            document.getElementById('mobile').style.border = '1px solid red';
            mobileInfo.style.display = 'block';
            mobileInfo.innerHTML = "Enter mobile phone number!";
            status.innerHTML = "Fill out all of the form data!";
        }

        // POSTAL CODE VALIDATION
        if (postal_code == "") {
            document.getElementById('postal_code').style.border = '1px solid red';
            postalInfo.style.display = 'block';
            postalInfo.innerHTML = "Enter postal code!";
            status.innerHTML = "Fill out all of the form data!";
        }

        // DATE OF BIRTH VALIDATION
        if (dob == "") {
            document.getElementById('dob').style.border = '1px solid red';
            dobInfo.style.display = 'block';
            dobInfo.innerHTML = "Enter date of birth!";
            status.innerHTML = "Fill out all of the form data!";
        }

        // GENDER VALIDATION
        if (gender == "") {
            document.getElementById('gender-group').style.border = '1px solid red';
            genderInfo.style.display = 'block';
            genderInfo.innerHTML = "Select gender!";
            status.innerHTML = "Fill out all of the form data!";
        }

        // TERMS & CONDITION VALIDATION
        if (checkBoxTerms == "") {
            document.getElementById('checkBoxTerms').style.border = '1px solid red';
            termsInfo.style.display = 'block';
            termsInfo.innerHTML = "You have to agree to the Terms &amp; Conditions to continue!";
            status.innerHTML = "Fill out all of the form data!";
        }

    } else {

        _("registerBtn").disabled = false;

        status.innerHTML = '<img src="img/spinner.png" alt="checking" />';

        var ajax = ajaxObj("POST", "register.php");

        ajax.onreadystatechange = function () {

            if (ajaxReturn(ajax) == true) {

                if (ajax.responseText != "signup_success") {

                    status.innerHTML = ajax.responseText;
                    _("registerBtn").disabled = false;

                } else {

                    <!--window.scrollTo(0,0);-->
                    _("registerBtn").innerHTML = "OK " + fname + ", check your email inbox and junk mail box at <a>" + email1 + "</a> in a moment to complete the sign up process by activating your account. You will not be able to do anything on the site until you successfully activate your account.";

                }
            }
        };
        ajax.send("email1=" + email1 + "&email2=" + email2 + "&password1=" + password1 + "&password2=" + password2 + "&fname=" + fname + "&lname=" + lname + "&address1=" + address1 + "&address2=" + address2 + "&country=" + country + "&county=" + county + "&town=" + town + "&postal_code=" + postal_code + "&mobile=" + mobile + "&dob=" + dob + "&gender=" + gender + "&checkBoxMail=" + checkBoxMail + "&checkBoxTxt=" + checkBoxTxt + "&checkBoxTerms=" + checkBoxTerms);

        //alert("alll:   email1=" + email1 + "&email2=" + email2 + "&password1=" + password1 + "&password2=" + password2 + "&fname=" + fname + "&lname=" + lname + "&address1=" + address1 + "&address2=" + address2 + "&country=" + country + "&county=" + county + "&town=" + town + "&postal_code=" + postal_code + "&mobile=" + mobile + "&dob=" + dob + "&gender=" + gender + "&checkBoxMail=" + checkBoxMail + "&checkBoxTxt=" + checkBoxTxt + "&checkBoxTerms=" + checkBoxTerms);

    }
}
function openTerms() {
    _("terms").style.display = "block";
    emptyElement("status");
}
/* function addEvents(){
 _("elemID").addEventListener("click", func, false);
 }
 window.onload = addEvents; */