# trafficaccident-online
trafficaccident 是基於使用MVC架構的laravel建構的網站，網站目的是為了讓警察更方便搜尋與統計勤務、案件，以及事故熱點分析
## views、model、controller
views使用大量bootstrap套件構成，透過連接Mysql資料庫，調取並運算資料，php計算、JavaScript製作圖表，再返回前端使用chart.js圖表呈現使用者快速並正確的得到視覺化的內容
## 事故熱點分析
採用了GIS系統結合K-means++計算事故熱點在地圖上的位置，並且設定巡邏點閥值，如果低於可返回熱點提醒，當作下次安排巡邏勤務參考依據
