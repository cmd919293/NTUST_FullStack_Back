@echo off
for /f %%a in ('type monstername.csv') do mkdir %%a
echo success
pause