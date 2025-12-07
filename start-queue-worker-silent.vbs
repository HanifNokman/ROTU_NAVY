Set WshShell = CreateObject("WScript.Shell")
WshShell.Run "cmd /c cd /d ""D:\xampp\htdocs\ROTU_NAVY"" && start-queue-worker.bat", 0, False
Set WshShell = Nothing
