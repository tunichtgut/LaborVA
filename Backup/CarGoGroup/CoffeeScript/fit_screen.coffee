window.getStyle = ->
	# Make sure there ARE stylesheets before using them...
	if document.styleSheets
		#alert("Styles found: "+document.styleSheets.length)
		myRules = new Array()
		viewportSize = getScreenSize();
		# Checks if the browser is standart compilant or the IE 6 :-)
		if document.styleSheets[0].cssRules
			myRules = document.styleSheets[0].cssRules
			for rule, index in myRules
				switch rule.selectorText
					when '#message h1' then myRules[index].style.fontSize=setH1Size(viewportSize)+"px"
					when '#message p' then myRules[index].style.fontSize=setParSize(viewportSize)+"px"
					when '#message'
						percentage = setMargins viewportSize
						myRules[index].style.marginTop=percentage+"px"
						myRules[index].style.marginBottom=percentage+"px"
					
		else if document.styleSheets[0].rules
			myRules = document.styleSheets[0].rules
			for index in [0..myRules.length]
				if myRules[index].selectorText.toLowerCase() != null
					switch myRules[index].selectorText.toLowerCase()
						when '#message h1' then myRules[index].style.fontSize=setH1Size(viewportSize)+"px"
						when '#message p' then myRules[index].style.fontSize=setParSize(viewportSize)+"px"
						when '#message'
							percentage = setMargins viewportSize
							myRules[index].style.marginTop=percentage+"px"
							myRules[index].style.marginBottom=percentage+"px"
					
	else
		alert("No style found")

# Quick and dirty. Should be rewritten to something more robust?
window.onresize = ->
	getStyle()
	
setH1Size = (viewport) ->
	width = viewport[0]
	height = viewport[1]
	
	#Let the font size of the headline be 9,18% of the smaller amout (width|height)
	if width < height
		return parseInt 0.0918*width
	else
		return parseInt 0.0918*height
		
setParSize = (viewport) ->
	width = viewport[0]
	height = viewport[1]

	#Let the font size of the paragraph be 3,7% of the smaller amout (width|height)
	if width < height
		return parseInt 0.037*width
	else
		return parseInt 0.037*height


###
This function returns the size of the top and bottom margin in dependency
of the viewport height, mode (portrait or landscape) and aspect ratio.
###
setMargins = (viewport) ->
	width = viewport[0]
	height = viewport[1]

	if height > width and height/width < 0.79 #Greater 0.75 means "all wider 4:3" in portrait mode
		return parseInt 0.3*height
	else
		return parseInt 0.2*height