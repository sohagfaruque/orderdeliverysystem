function TView(pid) {
	if (pid == 'tform_01') {
		document.getElementById('tform_01').style.display = 'block';
		document.getElementById('tform_02').style.display = 'none';
		document.getElementById('tform_03').style.display = 'none';
		document.getElementById('tform_04').style.display = 'none';
		document.getElementById('dform_01').className = 'hd-nav-active';
		document.getElementById('dform_02').className = 'hd-nav';
		document.getElementById('dform_03').className = 'hd-nav';
		document.getElementById('dform_04').className = 'hd-nav';
	}
	if (pid == 'tform_02') {
		document.getElementById('tform_01').style.display = 'none';
		document.getElementById('tform_02').style.display = 'block';
		document.getElementById('tform_03').style.display = 'none';
		document.getElementById('tform_04').style.display = 'none';
		document.getElementById('dform_01').className = 'hd-nav';
		document.getElementById('dform_02').className = 'hd-nav-active';
		document.getElementById('dform_03').className = 'hd-nav';
		document.getElementById('dform_04').className = 'hd-nav';
	}
	if (pid == 'tform_03') {
		document.getElementById('tform_01').style.display = 'none';
		document.getElementById('tform_02').style.display = 'none';
		document.getElementById('tform_03').style.display = 'block';
		document.getElementById('tform_04').style.display = 'none';
		document.getElementById('dform_01').className = 'hd-nav';
		document.getElementById('dform_02').className = 'hd-nav';
		document.getElementById('dform_03').className = 'hd-nav-active';
		document.getElementById('dform_04').className = 'hd-nav';
	}
	if (pid == 'tform_04') {
		document.getElementById('tform_01').style.display = 'none';
		document.getElementById('tform_02').style.display = 'none';
		document.getElementById('tform_03').style.display = 'none';
		document.getElementById('tform_04').style.display = 'block';
		document.getElementById('dform_01').className = 'hd-nav';
		document.getElementById('dform_02').className = 'hd-nav';
		document.getElementById('dform_03').className = 'hd-nav';
		document.getElementById('dform_04').className = 'hd-nav-active';
	}
}

function Visible(pid) {
	if (document.getElementById(pid).style.display == 'none') {
		document.getElementById(pid).style.display = 'block';
	}
	else {
		document.getElementById(pid).style.display = 'none';
	}
}

function XView(pid) {
	if (pid == 'xform_01') {
		document.getElementById('xform_01').style.display = 'block';
		document.getElementById('xform_02').style.display = 'none';
		document.getElementById('sform_01').className = 'hd-nav-active';
		document.getElementById('sform_02').className = 'hd-nav';
	}
	if (pid == 'xform_02') {
		document.getElementById('xform_01').style.display = 'none';
		document.getElementById('xform_02').style.display = 'block';
		document.getElementById('sform_01').className = 'hd-nav';
		document.getElementById('sform_02').className = 'hd-nav-active';
	}
}



function WView(pid) {
	if (pid == 'wform_01') {
		document.getElementById('wform_01').style.display = 'block';
		document.getElementById('wform_02').style.display = 'none';
		document.getElementById('wform_03').style.display = 'none';
		document.getElementById('zform_01').className = 'hd-nav-active';
		document.getElementById('zform_02').className = 'hd-nav';
		document.getElementById('zform_03').className = 'hd-nav';
	}
	if (pid == 'wform_02') {
		document.getElementById('wform_01').style.display = 'none';
		document.getElementById('wform_02').style.display = 'block';
		document.getElementById('wform_03').style.display = 'none';
		document.getElementById('zform_01').className = 'hd-nav';
		document.getElementById('zform_02').className = 'hd-nav-active';
		document.getElementById('zform_03').className = 'hd-nav';
	}
	if (pid == 'wform_03') {
		document.getElementById('wform_01').style.display = 'none';
		document.getElementById('wform_02').style.display = 'none';
		document.getElementById('wform_03').style.display = 'block';
		document.getElementById('zform_01').className = 'hd-nav';
		document.getElementById('zform_02').className = 'hd-nav';
		document.getElementById('zform_03').className = 'hd-nav-active';
	}
}
