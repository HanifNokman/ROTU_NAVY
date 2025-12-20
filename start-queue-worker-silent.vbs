Set WshShell = CreateObject("WScript.Shell")
WshShell.Run chr(34) & "d:\xampp\htdocs\ROTU_NAVY\start-queue-worker.bat" & Chr(34), 0
Set WshShell = Nothing
