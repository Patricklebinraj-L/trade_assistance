$c = Get-Content 'c:\xampp\htdocs\trade_assistance\assets\js\app.js' -Raw
Write-Host "Length:" $c.Length
Write-Host "Has tryInitChart:" ($c.IndexOf('tryInitChart') -ge 0)
Write-Host "Has clearWarning:" ($c.IndexOf('clearWarning') -ge 0)
Write-Host "Has loadOrderbook:" ($c.IndexOf('loadOrderbook') -ge 0)
Write-Host "Has loadTrades:" ($c.IndexOf('loadTrades') -ge 0)
Write-Host "Has retry:" ($c.IndexOf('retry=') -ge 0)
Write-Host "Has setInterval(refresh,5000):" ($c.IndexOf('setInterval(refresh,5000)') -ge 0)