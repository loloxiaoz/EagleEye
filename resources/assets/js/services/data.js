import {promiseGet} from './index'
const BIZ = "http://eagle.loloxiaoz.com"

export const dataLists= (params={}) =>{
  const url = `${BIZ}/data/list` ;
  return promiseGet(url,params)
}
