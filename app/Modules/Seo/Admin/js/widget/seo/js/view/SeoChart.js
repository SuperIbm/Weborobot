Ext.define('Seo.widget.seo.view.SeoChart', 
	{
	extend: 'Ext.chart.CartesianChart',
	alias: 'widget.Seo.widget.seo.view.SeoChart',
		
	store: "SeoWidget",
	
		legend: 
		{
		docked: 'bottom'
		},
	
	stacked: false,
	border: false,
	animate: true,
	
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
			}
		]
	}
);