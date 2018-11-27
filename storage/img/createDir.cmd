@echo off
for /f %%a in ('type monstername.csv') do (
	mkdir "%%a"
	move ".\Image\%%a.jpg" ".\%%a"
)
rmdir Image
echo success
pause