function SubmitItem_global(pid)
{	
	if(checkBlankField(document.form_01.mgmt_name.value) == false)
	{	alert("Please enter the user name.");
		document.form_01.mgmt_name.select();
		return false;
	}
	if (checkBlankField(document.form_01.mgmt_email.value) == false )
    {
        alert ( "Please enter the email address." );
		document.form_01.mgmt_email.select();
        return false;
    }
	else
	{
		if(valid_email(document.form_01.mgmt_email.value)==true)
		{
			alert ( "Please enter the correct email address." );
			document.form_01.mgmt_email.focus()
			return false
		}
	}
	if (checkBlankField(document.form_01.from_email.value) == false )
    {
        alert ( "Please enter the from email address." );
		document.form_01.from_email.select();
        return false;
    }
	else
	{
		if(valid_email(document.form_01.from_email.value)==true)
		{
			alert ( "Please enter the correct from email address." );
			document.form_01.from_email.focus()
			return false
		}
	}
	
	if (checkBlankField(document.form_01.footer_address.value) == false )
    {
        alert ( "Please enter the footer address." );
		document.form_01.footer_address.select();
        return false;
    }
	if (checkBlankField(document.form_01.phone_number.value) == false )
    {
        alert ( "Please enter the phone number." );
		document.form_01.phone_number.select();
        return false;
    }
	if (checkBlankField(document.form_01.credit_bottle.value) == false )
    {
        alert ( "Please enter the credit per bottle." );
		document.form_01.credit_bottle.select();
        return false;
    }
	

	
	if (checkBlankField(document.form_01.no_of_days_msg.value) == false )
    {
        alert ( "Please enter the fax number." );
		document.form_01.no_of_days_msg.select();
        return false;
    }
	
	document.form_01.submit();	
}