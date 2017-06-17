webpackJsonp([1],{

/***/ 56:
/***/ (function(module, exports, __webpack_require__) {

var Component = __webpack_require__(46)(
  /* script */
  __webpack_require__(57),
  /* template */
  __webpack_require__(58),
  /* scopeId */
  null,
  /* cssModules */
  null
)
Component.options.__file = "/home/wwwroot/EagleEye/resources/assets/js/components/form.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key !== "__esModule"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] form.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-6c6f25a5", Component.options)
  } else {
    hotAPI.reload("data-v-6c6f25a5", Component.options)
  }
})()}

module.exports = Component.exports


/***/ }),

/***/ 57:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
    data: function data() {
        return {
            columns1: [{
                title: '姓名',
                key: 'name'
            }, {
                title: '年龄',
                key: 'age'
            }, {
                title: '地址',
                key: 'address'
            }],
            data1: [{
                name: '王小明',
                age: 18,
                address: '北京市朝阳区芍药居'
            }, {
                name: '张小刚',
                age: 25,
                address: '北京市海淀区西二旗'
            }, {
                name: '李小红',
                age: 30,
                address: '上海市浦东新区世纪大道'
            }, {
                name: '周小伟',
                age: 26,
                address: '深圳市南山区深南大道'
            }]
        };
    }
});

/***/ }),

/***/ 58:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('Table', {
    attrs: {
      "columns": _vm.columns1,
      "data": _vm.data1
    }
  })
},staticRenderFns: []}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-6c6f25a5", module.exports)
  }
}

/***/ })

});