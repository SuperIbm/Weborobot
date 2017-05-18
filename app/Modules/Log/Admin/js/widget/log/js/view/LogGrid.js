Ext.define('Log.widget.log.view.LogGrid',
	{
    extend: 'Admin.view.ux.GridPanel',
	alias: 'widget.Log.widget.log.view.LogGrid',

        requires:
        [
        "Log.view.LogGrid"
        ],

    store: 'Log',
    selType: "rowmodel",
    border: false,

    multiColumnSort: false,
		
		dockedItems:
		[
			{
			xtype: 'pagingtoolbar',
			store: 'Log',
			dock: 'bottom',
			displayInfo: false
			}
		],
		
		columns:
		[
            {
			header: 'Дата добавления',
			dataIndex: 'date',
			width: "25%"
            },
            {
			header: 'Пользователь',
			dataIndex: 'login',
			width: "25%",
			sortable: false
            },
            {
			header: 'Модуль',
			dataIndex: 'module',
			width: "25%",
			sortable: false
            },
            {
			header: 'Уровень',
			dataIndex: 'level',
			width: "25%"
            }
		]
	}
);