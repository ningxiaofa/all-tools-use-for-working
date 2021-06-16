const fs = require('fs')

const ID = require('./js/Js2Csv/id/id.js');
const TH = require('./js/Js2Csv/th/th.js');

const IDJsonStr = JSON.stringify(ID);
const THJsonStr = JSON.stringify(TH);

// Optimization: Output to file of json/th/th.json / json/id/id.json
const contentObj = {
    id: IDJsonStr,
    th: THJsonStr
};

const dir = './json/Js2Csv/';
const currTimeStamp = Date.now();
for(const key in contentObj){
    // 异步写入
    fs.writeFile(`${dir}${key}/${key}-${currTimeStamp}.json`, contentObj[key], err => {
        if (err) {
            console.error(err)
            return
        }
        console.log('Write successfully!');
    })
}
