@echo off
REM curl -X GET --header "Accept: application/json" https://data.gov.rs/api/1/datasets/?page_size=30 -o dataset1_30.json
curl https://data.gov.rs/api/1/datasets/?page_size=30 -o dataset1_30.json
