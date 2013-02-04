getScreenSize = ->
	ifDocElem = false
	ifClntWidth = false

	if typeof document.documentElement != 'undefined'
		ifDocElem = true

	if typeof document.documentElement.clientWidth != 'undefined'
		ifClntWidth = true
	if document.documentElement.clientWidth == 0
		ifClntWidth = false

	#the more standards compliant browsers (mozilla/netscape/opera/IE7) use window.innerWidth and window.innerHeight

	if typeof window.innerWidth != 'undefined'
		viewportwidth = window.innerWidth
		viewportheight = window.innerHeight
		return viewport = [viewportwidth, viewportheight]

	#IE6 in standards compliant mode (i.e. with a valid doctype as the first line in the document)

	else if ifDocElem and ifClntWidth
		viewportwidth = document.documentElement.clientWidth
		viewportheight = document.documentElement.clientHeight
		return viewport = [viewportwidth, viewportheight]

	#older versions of IE
	else
		viewportwidth = document.getElementsByTagName('body')[0].clientWidth
		viewportheight = document.getElementsByTagName('body')[0].clientHeight
		return viewport = [viewportwidth, viewportheight]