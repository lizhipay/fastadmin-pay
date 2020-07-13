define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {
    var Controller = {
        index: function () {
            //
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'lizhifu/order/index',
                    table: 'lizhifu_order',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                escape: false,
                pk: 'id',
                sortName: 'id',
                commonSearch: false,
                search: false,
                pageSize: 20,
                pageList: [20, 30, 50, 100, 500, 1000],
                columns: [
                    [
                        {checkbox: true},
                        {field: 'trade_no', title: '订单号'},
                        {field: 'amount', title: '下单金额'},
                        {field: 'channel.name', title: '支付通道'},
                        {field: 'user.username', title: '下单用户'},
                        {field: 'status', title: '状态', formatter: Controller.api.formatter.status},
                        {
                            field: 'createtime',
                            title: '创建时间',
                            formatter: Table.api.formatter.datetime,
                            operate: 'RANGE',
                            addclass: 'datetimerange',
                            sortable: true
                        },
                        {
                            field: 'paytime',
                            title: '支付时间',
                            formatter: Table.api.formatter.datetime,
                            operate: 'RANGE',
                            addclass: 'datetimerange',
                            sortable: true
                        }
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            },
            formatter: {
                status: function (value, row, index) {
                    return value == 1 ? '<span style="color: green;">已支付</span>' : '<span style="color: red;">未支付</span>';
                }
            }
        }
    };
    return Controller;
});