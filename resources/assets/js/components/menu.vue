<style scoped>
    .full-content{
        height : 100%;
    }
    .layout{
        border: 1px solid #d7dde4;
        background: #f5f7f9;
        position: relative;
        border-radius: 4px;
        overflow: hidden;
    }
    .layout-breadcrumb{
        padding: 10px 15px 0;
    }
    .layout-content{
        min-height: 200px;
        margin: 15px;
        overflow: hidden;
        background: #fff;
        border-radius: 4px;
    }
    .layout-content-main{
        padding: 10px;
    }
    .layout-copy{
        text-align: center;
        padding: 10px 0 20px;
        color: #9ea7b4;
    }
    .layout-menu-left{
        background: #464c5b;
    }
    .layout-header{
        height: 60px;
        background: #fff;
        box-shadow: 0 1px 1px rgba(0,0,0,.1);
    }
    .layout-logo-left{
        width: 90%;
        height: 30px;
        background: #5b6270;
        border-radius: 3px;
        margin: 15px auto;
    }
    .layout-ceiling-main a{
        color: #9ba7b5;
    }
    .layout-hide-text .layout-text{
        display: none;
    }
    .ivu-col{
        transition: width .2s ease-in-out;
    }
</style>
<template>
    <div class="layout full-content">
        <Row type="flex" class="full-content">
            <i-col :span="spanLeft" class="layout-menu-left full-content">
                <Menu active-name="1" theme="dark" width="auto">
                    <Menu-item name="1">
                        <Icon type="ios-navigate" :size="iconSize"></Icon>
                        <span class="layout-text">选项 1</span>
                    </Menu-item>
                    <Menu-item name="2">
                        <Icon type="ios-keypad" :size="iconSize"></Icon>
                        <span class="layout-text">选项 2</span>
                    </Menu-item>
                </Menu>
            </i-col>
            <i-col :span="spanRight">
                <div class="layout-header">
                    <i-button type="text" @click="toggleClick">
                        <Icon type="navicon" size="32"></Icon>
                    </i-button>
                </div>
                <div class="layout-breadcrumb">
                    <Breadcrumb>
                        <Breadcrumb-item href="#">首页</Breadcrumb-item>
                        <Breadcrumb-item href="#">应用中心</Breadcrumb-item>
                    </Breadcrumb>
                </div>
                <div class="layout-breadcrumb">
                    <Form :model="formItem" :label-width="80">
                        <Row>
                            <Col span="6">
                            <Form-item label="网站">
                                <Select style="width:200px" label="选择网站" :model.sync=formItem.website @on-change="chooseWeb">
                                    <Option v-for="item in websiteList" :value="item.value" :key="item">{{ item.name }}</Option>
                                </Select>
                            </Form-item>
                            </Col>
                            <Col span="6">
                            <Form-item label="开始时间">
                                <Date-picker type="datetime" format="yyyy-MM-dd" placeholder="选择日期" :value="formItem.beginTime" @on-change="chooseBT" style="width: 200px"></Date-picker>
                            </Form-item>
                            </Col>
                            <Col span="6">
                            <Form-item label="结束时间">
                                <Date-picker type="datetime" format="yyyy-MM-dd" placeholder="选择日期" :value="formItem.endTime" @on-change="chooseET" style="width: 200px"></Date-picker>
                            </Form-item>
                            </Col>
                            <Col span="6">
                            <Form-item style="text-align:center;">
                                <i-button type="primary" @click="handleSubmit('formItem')" >提交</i-button>
                            </Form-item>
                            </Col>
                        </Row>
                    </Form>
                </div>
                <div class="layout-content">
                    <div class="layout-content-main">内容区域</div>
                        <Table height="700" :columns="columns1" :data="data1"></Table>
                </div>
                <div class="layout-copy">
                    2016-2021 &copy; Loloxiaoz
                </div>
            </i-col>
        </Row>
    </div>
</template>
<script>
import {dataLists,getNowFormatDate} from '../services/data'
export default {
    mounted() {
        this.getData();
    },
    data () {
        return {
            spanLeft: 5,
            spanRight: 19,
            formItem: {
                website: "",
                beginTime: getNowFormatDate(new Date(new Date()-24*60*60*1000*5)),
                endTime: getNowFormatDate(new Date())            
            },
            columns1: [
                {
                    title: '日期',
                    key: 'name'
                },
                {
                    title: '网站',
                    key: 'url'
                },
                {
                    title: '公司名',
                    key: 'address'
                }
            ],
            websiteList: [
                {
                    name: '58同城',
                    value: '58'
                },
                {
                    name: '猎聘',
                    value: 'LiePin'
                },
                {
                    name: '中华英才网',
                    value: 'ChinaHr'
                },
                {
                    name: '吴江hr',
                    value: 'WujiangHr'
                },
                {
                    name: '锦绣网',
                    value: 'Zp0512'
                }
            ],
            data1: [],
        }
    },
    computed: {
        iconSize () {
            return this.spanLeft === 5 ? 14 : 24;
        }
    },
    methods: {
        toggleClick () {
            if (this.spanLeft === 5) {
                this.spanLeft = 2;
                this.spanRight = 22;
            } else {
                this.spanLeft = 5;
                this.spanRight = 19;
            }
        },
        async getData(){
            var self=this;
            self.data1 = [];
            const datas=await dataLists({
                website:this.formItem.website,
                beginTime:this.formItem.beginTime,
                endTime:this.formItem.endTime
            });
            datas.forEach(function(value){
                    var obj={};
                    obj.name=value.ymd;
                    obj.url=value.url;
                    obj.address=value.content;
                    self.data1.push(obj)
            });
        },
        chooseWeb(value){
            this.formItem.website=value;
        },
        chooseBT(date){
            this.formItem.beginTime=date;
        },
        chooseET(date){
            this.formItem.endTime=date;
        },
        handleSubmit(formItem){
            this.getData();
        },
    }
}
</script>
