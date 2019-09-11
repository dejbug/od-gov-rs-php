function cb_toggle_expand(node) {
	// toggle_expand_with_last(node);
	toggle_expand(node);
}

var last = null;

function toggle_expand_with_last(node) {
	if (last) toggle_expand(last);
	if (last === node) last = null;
	else { toggle_expand(node); last = node; }
}

function toggle_expand(node) {
	node.firstChild.classList.toggle("long");
	node.classList.toggle("mark");
}
