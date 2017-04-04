on run argv
	tell application "System Events"
	    set desktopCount to count of desktops
	    repeat with desktopNumber from 1 to desktopCount
	        tell desktop desktopNumber
	            set picture to item 1 of argv
	        end tell
	    end repeat
	end tell
end run
