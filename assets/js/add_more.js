/*
This script is identical to the above JavaScript function.
*/
var ct = 1;

function new_link()
{
	ct++;
	var div1 = document.createElement('div');
	div1.id = ct;

	// link to delete extended form elements
	var delLink = '<div style="text-align:right;margin-right:65px"><a href="javascript:delIt('+ ct +')">Del</a></div>';

	div1.innerHTML = document.getElementById('newlinktpl').innerHTML + delLink;

	document.getElementById('newlink').appendChild(div1);

}
// function to delete the newly added set of elements
function delIt(eleId)
{
	d = document;

	var ele = d.getElementById(eleId);

	var parentEle = d.getElementById('newlink');

	parentEle.removeChild(ele);

}

function more_size()
{
ct++;
	var div1 = document.createElement('div');
	div1.id = ct;

	// link to delete extended form elements
	var delLink = '<div style="text-align:right;margin-right:65px"><a href="javascript:delsize('+ ct +')">Del</a></div>';

	div1.innerHTML = document.getElementById('more_size').innerHTML + delLink;

	document.getElementById('newsize').appendChild(div1);

}

function delsize(eleId)
{
	d = document;
	var parentID='newsize_'+eleId;
	var ele = d.getElementById(eleId);
	
	var parentEle = d.getElementById('newsize_'+eleId);

	parentEle.removeChild(ele);

}




function more_image()
{
ct++;
	var div1 = document.createElement('div');
	div1.id = ct;

	// link to delete extended form elements
	var delLink = '<div style="text-align:right;margin-right:65px"><a href="javascript:delimg('+ ct +')">Del</a></div>';

	div1.innerHTML = document.getElementById('more_image').innerHTML + delLink;

	document.getElementById('newimage').appendChild(div1);

}

function delimg(eleId)
{
	d = document;

	var ele = d.getElementById(eleId);

	var parentEle = d.getElementById('newimage');

	parentEle.removeChild(ele);

}

function category_ids(id)
{

		  
	
	
	/* For select Sub Categoty getting   */
    var httpstate;		
	url="ajax_sub_cat.php?cat_id="+escape(id);		
	
	if(window.XMLHttpRequest){
			httpstate=new XMLHttpRequest();
		}else if(window.ActiveXObject){
			httpstate=new ActiveXObject('msxml2.XMLHTTP');
		}
		if(httpstate){
			httpstate.open('get',url,true);
			httpstate.send(null);
			httpstate.onreadystatechange=function(){
				if(httpstate.readyState==4){
					if(httpstate.status==200){


						//alert(httpstate.responseText);
						document.getElementById('sub_cat').innerHTML = httpstate.responseText;
					}
				}
				else
				{
					//document.getElementById('favrt').innerHTML = 'Please Wait....';
				}
			}
		}


	/* For select Sub Categoty getting   */
	


}

//#########FOR ADD MORE PLAYER PROFILE IN  MEDIA CONTENT#####//
function more_profile()
{
ct++;
	var div1 = document.createElement('div');
	div1.id = ct;

	// link to delete extended form elements
	var delLink = '<div style="text-align:right;margin-right:65px"><a href="javascript:delimg('+ ct +')">Del</a></div>';

	div1.innerHTML = document.getElementById('more_profile').innerHTML + delLink;

	document.getElementById('newimage').appendChild(div1);

}

function delimg(eleId)
{
	d = document;

	var ele = d.getElementById(eleId);

	var parentEle = d.getElementById('newimage');

	parentEle.removeChild(ele);

}

//#########FOR ADD MORE PLAYER PROFILE IN  MEDIA CONTENT#####//