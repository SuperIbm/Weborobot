Ext.define('Seo.view.SeoGrid', 
	{
    extend: 'Admin.view.ux.GridPanel',
	alias: 'widget.Seo.view.SeoGrid',	
	
	store: 'Seo',
		
	forceFit: true,
	border: false,

		features:
		[
			{
			id: 'summary',
			ftype: 'summary',
			dock: "bottom"
			}
		],
	
		columns:
		[
			{
			header: 'Дата',
			dataIndex: 'dateStat',
			width: 25,
			xtype: 'datecolumn',
            format: "d.m.Y"
			},
			{
			header: 'Визиты',
			dataIndex: 'countVisits',
			width: 15,
			summaryType: 'sum'
			},
			{
			header: 'Просмотры',
			dataIndex: 'countShows',
			width: 15,
			summaryType: 'sum'
			},
			{
			header: 'Посетители',
			dataIndex: 'countVisitors',
			width: 15,
			summaryType: 'sum'
			},
			{
			header: 'Новые посетители',
			dataIndex: 'countVisitorsNew',
			width: 15,
			summaryType: 'sum'
			},
			{
			header: 'Глубина просмотра',
			dataIndex: 'showsDeep',
			width: 15,
			summaryType: 'average',
				summaryRenderer: function(value, summaryData, dataIndex)
				{
					return "Средняя: " + Weborobot.Util.toFixed(value, 2);
				}
			}
		]
	}
);