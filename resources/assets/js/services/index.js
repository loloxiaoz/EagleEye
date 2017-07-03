import axios from 'axios'
require("babel-core/register");
require("babel-polyfill");
require('es6-promise').polyfill();

export const _get = ({ url, params }) => {
  const promise = axios.get(url,{params : params});
  return new Promise((resolve,reject) => {
    promise.then((result)=>{
      resolve(result.data);
    }).catch((error)=>{
      reject(error.response.data);
    })
  })
};

export const promiseGet=(url,params)=>new Promise((resolve,reject) => {
    _get({url,params})
   .then((result)=>{
        resolve(result);
   }).catch((e)=>{   
       reject(e);
   })
});


