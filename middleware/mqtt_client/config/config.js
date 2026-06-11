var db = require('./db');
const query = {
  // give the query a unique name
  name: 'fetch-user',
  text: 'SELECT * FROM gateways WHERE id = $1',
  values: [3],
}
var gateway = [];
// callback
// var datas = function (){
  const array = db.query(query, (err, res) => {
    if (err) {
      console.log(err.stack)
    } else {
      // console.log(res.rows);
      gateway.push(res.rows[0]);
      // console.log(gateway);
      // module.exports = gateway;
    }

    return res.rows[0];
  })
  console.log(array);
// }
// console.log(datas, array);
// db.query(query).then(res => console.log(res.rows[0])).catch(e => console.error(e.stack))