Ext.define('Seo.view.SeoChart', 
	{
    extend: 'Ext.chart.CartesianChart',
	alias: 'widget.Seo.view.SeoChart',
		
	store: "Seo",
	
		legend: 
		{
		docked: 'bottom'
		},
		
	interactions: ['iteminfo'],
	stacked: false,
	border: false,
	
		axes:
		[ 
			{
			type: 'category',
			position: 'bottom',
			fields: ['dateShow'],
			grid: true,
				title: 
				{
				text: 'Период'
				}
			},
			{
			type: 'numeric',
			position: 'left',
			grid: true
			}
		],
		
		series:
		[
			{
			type: 'line',
			axes: "left",
			xField: 'dateShow',
            yField: 'countVisits',
			title: "Визиты",
				style: 
				{
				'stroke-width': 3
				},
				markerConfig: 
				{
				radius: 3
				},
				tooltip:
				{
				trackMouse: true,
				style: 'background: #FFF',
				height: 25,
				showDelay: 0,
				dismissDelay: 0,
				hideDelay: 0,
					renderer: function(tooltip, record, item)
					{
					tooltip.setHtml(record.get("dateShow") + ": " + record.get(item.field));
					}
                },
				marker: 
				{
				type: 'circle',
				radius: 3,
				lineWidth: 3,
				fill: 'white'
				}
			},
			{
			type: 'line',
			axes: "left",
			xField: 'dateShow',
            yField: 'countShows',
			title: "Просмотры",
				style: 
				{
				'stroke-width': 3
				},
				markerConfig: 
				{
				radius: 3
				},
				tooltip:
				{
				trackMouse: true,
				style: 'background: #FFF',
				height: 25,
				showDelay: 0,
				dismissDelay: 0,
				hideDelay: 0,
					renderer: function(tooltip, record, item)
					{
					tooltip.setHtml(record.get("dateShow") + ": " + record.get(item.field));
					}
                },
				marker: 
				{
				type: 'circle',
				radius: 3,
				lineWidth: 3,
				fill: 'white'
				}	
			},
			{
			type: 'line',
			axes: "left",
			xField: 'dateShow',
            yField: 'countVisitors',
			title: "Посетители",
				style: 
				{
				'stroke-width': 3
				},
				markerConfig: 
				{
				radius: 3
				},
				tooltip:
				{
				trackMouse: true,
				style: 'background: #FFF',
				height: 25,
				showDelay: 0,
				dismissDelay: 0,
				hideDelay: 0,
					renderer: function(tooltip, record, item)
					{
					tooltip.setHtml(record.get("dateShow") + ": " + record.get(item.field));
					}
                },
				marker: 
				{
				type: 'circle',
				radius: 3,
				lineWidth: 3,
				fill: 'white'
				}	
			},
			{
			type: 'line',
			axes: "left",
			xField: 'dateShow',
            yField: 'countVisitorsNew',
			title: "Новые посетители",
				style: 
				{
				'stroke-width': 3
				},
				markerConfig: 
				{
				radius: 3
				},
				tooltip:
				{
				trackMouse: true,
				style: 'background: #FFF',
				height: 25,
				showDelay: 0,
				dismissDelay: 0,
				hideDelay: 0,
					renderer: function(tooltip, record, item)
					{
					tooltip.setHtml(record.get("dateShow") + ": " + record.get(item.field));
					}
                },
				marker: 
				{
				type: 'circle',
				radius: 3,
				lineWidth: 3,
				fill: 'white'
				}	
			},
			{
			type: 'line',
			axes: "left",
			xField: 'dateShow',
            yField: 'showsDeep',
			title: "Глубина просмотра",
				style: 
				{
				'stroke-width': 3
				},
				markerConfig: 
				{
				radius: 3
				},
				tooltip:
				{
				trackMouse: true,
				style: 'background: #FFF',
				height: 25,
				showDelay: 0,
				dismissDelay: 0,
				hideDelay: 0,
					renderer: function(tooltip, record, item)
					{
					tooltip.setHtml(record.get("dateShow") + ": " + record.get(item.field));
					}
                },
				marker: 
				{
				type: 'circle',
				radius: 3,
				lineWidth: 3,
				fill: 'white'
				}	
			}
		],
		
		tbar:
		[
			"->",
			{
			xtype: "button",
			text: "Скачать",
			action: "download",
			iconCls: "icon_Seo_save_small"	
			}
		]
	}
);