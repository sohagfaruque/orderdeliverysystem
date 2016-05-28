
function valid_email(eml)
{
	//declare the required variables
	var mint_len;
	var mstr_eml=eml;
	var mint_at=0;
	var mint_atnum=0;
	var mint_dot=0;
	var mint_dotnum=0;

	mint_len = eml.length; //takes the length of the email address entered
	//checking for the symbol single quote. If found replace it with its html code
	if (mstr_eml.indexOf("'")!=-1)
	{	
		mstr_eml=mstr_eml.replace("'","'");
	}
	//checking for the (@) & (.) symbol
	for(var iloop=0;iloop<mint_len;iloop++)
	{
		if(mstr_eml.charAt(iloop)=="@")
		{
			mint_at=iloop+1;
			mint_atnum=mint_atnum+1;
		}
		if(mstr_eml.charAt(iloop)==".")
		{
			mint_dot=iloop+1;
			mint_dotnum=mint_dotnum+1;
		}
	}
	//if nothing entered in the field
	if (mstr_eml=="")
	{
		return true;
	}
	//if @ entered more than once & dot (.) entered more than 4 times
	else if((mint_atnum!=1)||(mint_dotnum>4)||((mint_dot-mint_at)<2)||((mint_len-mint_dot)<2)||(mint_at<3))
	{
		return true;
	}
	//if any blank space is entered in the email address
	else if (mstr_eml.indexOf(" ")!=-1)
	{
		return true;
	}
	return false;
}
function checkBlankField (txt)
{
	var mint_txt = txt.length;
	var mstr_txt = txt;
	var mint_count = 0;
	for (var iloop = 0; iloop<mint_txt; iloop++)
	{
        if (mstr_txt.charAt(iloop) == " ")
        {
           mint_count = mint_count+1;
        }
	}    
// if nothing entered in the field
	if (txt == "")
   	{
		return false;
	}
	else if (mint_count == mint_txt)
	{
		return false;
	}
	return true;
}
function IsNumeric(strString)
{
	var strValidChars = "0123456789.";
	var strChar;
	var blnResult = true;
	if (strString.length == 0) return false;
		for (i = 0; i < strString.length && blnResult == true; i++)
		{
			strChar = strString.charAt(i);
			if (strValidChars.indexOf(strChar) == -1)
			{
			blnResult = false;
			}
		}
   		return blnResult;
 }

 function openWindow(url,width,height,resize,scrl) 
{	
	width=(width==null || width=='')?400:width;
	height=(height==null || height=='')?300:height;
	resize=(resize==null || resize=='')?'yes':resize;
	scrl=(scrl==null || scrl=='')?'no':scrl;
	
	window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars='+scrl+',resizable='+resize+',copyhistory=no,width='+width+',height='+height+',screenX=150,screenY=150,top=150,left=80')
}

function go_link(url, root)
 {	 
	 if(!url.match(root))
	 {
		 var r=confirm("You are now leaving Heb Homes website.  We are not responsible for the content of external internet sites.  Click OK to proceed.");

		 if(r==true)
		 {
			 window.open(url, "blank");
		 }

	 }
	 else
	 {
		 document.location.href=url;
	 }
}

 

 function GetXmlHttpObject()
{
	if (window.XMLHttpRequest)
	{
		// code for IE7+, Firefox, Chrome, Opera, Safari
		return new XMLHttpRequest();
	}
	if (window.ActiveXObject)
	{
		// code for IE6, IE5
		return new ActiveXObject("Microsoft.XMLHTTP");
	}
		return null;
}