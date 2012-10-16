<?php
	header('Content-Type: application/javascript');

	if(!isset($_GET['lang']) || !isset($_GET['label1']) || !isset($_GET['label2'])) exit("var redactorSettings = {};") ;

	$lang 	= strip_tags(urldecode($_GET['lang']));
	$label1 = strip_tags(urldecode($_GET['label1']));
	$label2 = strip_tags(urldecode($_GET['label2']));
?>

redactorSettings = {
	focus: true,
	<?php
		if($lang !== "en") {
			echo "lang: '$lang',\n";
		}
	?>
	buttons:['formatting', '|', 'bold', 'italic', 'deleted', '|',
		    'unorderedlist', 'orderedlist', 'outdent', 'indent', '|',
		    'image', 'video', 'file', 'table', 'link', '|',
		    'fontcolor', 'backcolor', '|',
		    'alignleft', 'aligncenter', 'alignright', 'justify', '|',
		    'pagebreak', 'code']
};

redactorPlugins = {
	getSelectedHtml: function() {
		if ($(this).data("redactor")) {
			var sel;

			if (typeof window.getSelection === 'function') {
				sel = $(this).data("redactor").$frame.get(0).contentWindow.getSelection();

				if (sel.rangeCount) {
					var container = document.createElement("div");
					for (var i = 0; i < sel.rangeCount; i++) container.appendChild(sel.getRangeAt(i).cloneContents());
					return container.innerHTML;
				}
			} else if(typeof document.selection !== 'undefined') {
				sel = $(this).getDoc().selection;

				if (sel.type === "Text") {
					return sel.createRange().htmlText;
				}
			}
		}
		return '';
	},
	getSelectedTagName: function() {
		if ($(this).data("redactor")) {
			var sel;

			if (typeof window.getSelection === 'function') {
				sel = $(this).data("redactor").$frame.get(0).contentWindow.getSelection();
				return sel.getRangeAt(0).commonAncestorContainer.parentNode.tagName;
			} else if(typeof document.selection !== 'undefined') {
				sel = $(this).getDoc().selection;
				return sel.createRange().parentElement().nodeName;
			}
			return '';
		}
	},
	getSelectedText: function() {
		if ($(this).data("redactor")) {
			if (typeof window.getSelection === 'function') {
				return $(this).data("redactor").$frame.get(0).contentWindow.getSelection();
			} else if(typeof document.selection !== 'undefined') {
				return $(this).getDoc().selection.createRange();
			}
		}
		return '';
	}
};