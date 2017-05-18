Ext.define('Log.view.LogGrid',
	{
    extend: 'Admin.view.ux.GridPanel',
	alias: 'widget.Log.view.LogGrid',
	
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
			displayInfo: true
			}
		],
	
		columns:
		[
			{
			header: 'Дата добавления',
			dataIndex: 'date',
			width: "13%"
			},
            {
            header: 'Пользователь',
            dataIndex: 'login',
            width: "13%",
            sortable: false
            },
            {
            header: 'Модуль',
            dataIndex: 'module',
            width: "10%",
            sortable: false
            },
            {
			header: 'Тип действия',
			dataIndex: 'type',
			width: "9%",
			sortable: false
            },
			{
			header: 'Уровень',
			dataIndex: 'level',
			width: "10%",
				filter:
				{
				type: 'listFixed',
					options:
					[
						['info', 'Сообщение'],
						['alert', 'Внимание'],
						['critical', 'Критично'],
						['debug', 'Отладка'],
						['error', 'Ошибка'],
                        ['warning', 'Предупреждение']
					]
				}
			},
            {
			header: 'Окружение',
			dataIndex: 'environment',
			hidden: true,
                filter:
				{
				type: 'listFixed',
				single: true,
					options:
					[
						['local', 'Локальное'],
						['production', 'Рабочее']
					]
				}
            },
			{
			header: 'Заголовок',
			dataIndex: 'header',
			width: "10%",
                editor:
				{
				xtype: "textfield",
				readOnly: true
				}
			},
            {
			header: 'Время',
			dataIndex: 'time',
			width: "8%",
            sortable: false,
                renderer: function(value)
                {
                return Weborobot.Util.toFixed(value, 2) + " сек.";
                }
            },
            {
            header: 'Память',
            dataIndex: 'memory',
            width: "8%",
            sortable: false,
                renderer: function(value)
                {
                    if(value <= 1024) return Weborobot.Util.toFixed(value, 2) + " байт.";
                    else if(value > 1024 && value <= (1024 * 1024)) return Weborobot.Util.toFixed(value / 1024, 2) + " КБ.";
                    else if(value > (1024 * 1024)) return Weborobot.Util.toFixed(value / 1024 / 1024, 2) + " МБ.";
                }
            },
            {
            header: 'ЦПУ',
            dataIndex: 'cpu',
            width: "8%",
            sortable: false,
                renderer: function(value)
                {
                    return Weborobot.Util.toFixed(value, 2) + "%";
                }
            },
			{
			header: 'Стек',
			dataIndex: 'stack',
			width: "10%",
            sortable: false,
				editor:
				{
				xtype: "textareafield",
				readOnly: true,
				height: 150
				}
			}
		]
	}
);