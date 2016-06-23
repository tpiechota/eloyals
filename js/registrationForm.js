/*** Enable or disable submit button depending on the Terms & Condition checkbox. ***/
function SubmitButtonToggle() {
    var isDisabled = document.forms.registrationform.registerBtn.disabled;
    document.forms.registrationform.registerBtn.disabled = isDisabled ? false : true;
}


/***
 * Check the country field and change the caounty field accordingly.
 * If country id = 80 (Ireland) than insert county list else enable input field.
 ***/
function checkCountry() {

    var selectedCountry = _("country").value;
    var countyStatus = _("countyStatus");

    if (selectedCountry != 80) {
        _("countyStatus").innerHTML = '<label class=\"control-label\" for=\"county\">County:</label><input class=\"input-block-level\" type=\"text\" id=\"county\" name=\"county\" placeholder=\"Enter county name\" disabled=\"disabled\"/><div class=\"reg-status\" id=\"countyInfo\"></div>';
        _("county").disabled = false;
    }

    //_("send").disabled = false;

    var ajax = ajaxObj("POST", "app/inc/reg.country.inc.php");

    ajax.onreadystatechange = function () {

        if (ajaxReturn(ajax) == true) {

            if (ajax.responseText == "80") {
                _("countyStatus").innerHTML = '<label for=\"county\">County:</label><select id=\"county\" name=\"county\" class="input-block-level"><option value=\"\">Select county</option><?php echo getCounty(); ?></select><div class=\"reg-status\" id=\"countyInfo\"></div>';
            }

        }

    };

    ajax.send("selectedCountry=" + selectedCountry);
}