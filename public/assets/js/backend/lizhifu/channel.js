define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {
    var Controller = {
        index: function () {
            //
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'lizhifu/channel/index',
                    add_url: 'lizhifu/channel/add',
                    edit_url: 'lizhifu/channel/edit',
                    del_url: 'lizhifu/channel/del',
                    table: 'lizhifu_channel',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                escape: false,
                pk: 'id',
                sortName: 'sort',
                commonSearch: false,
                search: false,
                pageSize: 20,
                pageList: [20, 30, 50, 100, 500, 1000],
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: 'ID', operate: false},
                        {field: 'name', title: '通道名称'},
                        {field: 'code', title: '通道编号'},
                        {field: 'sort', title: '排序'},
                        {field: 'status', title: '状态', formatter: Controller.api.formatter.status},
                        {field: 'createtime', title: '创建时间', formatter: Table.api.formatter.datetime, operate: 'RANGE', addclass: 'datetimerange', sortable: true},
                        {
                            field: 'operate',
                            title: '操作',
                            table: table,
                            events: Table.api.events.operate,
                            formatter: Table.api.formatter.operate
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
                    return value == 1 ? '<span style="color: green;">启用</span>' : '<span style="color: red;">停用</span>';
                }
            }
        }
    };
    return Controller;
});