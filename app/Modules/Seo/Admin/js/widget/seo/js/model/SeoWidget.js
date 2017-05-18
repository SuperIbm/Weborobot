Ext.define('Seo.widget.seo.model.SeoWidget',
	{
    extend: 'Ext.data.Model',
	
	name: 'SeoWidget',
	idProperty: 'idSeo',
	clientIdProperty: "idSeo",
	
    	fields:
		[			
			{
			name: "idSeo",
			type: "int"
			},
			{
			name: "visits",
			type: "int"
			},
			{
			name: "shows",
			type: "int"
			},
			{
			name: "visitors",
			type: "int"
			},
			{
			name: "visitorsNew",
			type: "int"
			},
			{
			name: "showsDeep",
			type: "int"
			},
			{
			name: "groupMonths",
			type: "string"
			},
			{
			name: "groupWeeks",
			type: "string"
			},
			{
			name: "groupDays",
			type: "string"
			},
			{
			name: 'dateShow',
			type: "date",
			dateFormat: "d.m.Y", 
				convert: function(val, rec)
				{
				var Dt = Ext.Date.parse(val, "d.m.Y");
				
					if(rec.get("groupDays")) return Ext.Date.format(Dt, "d.m.Y");
					else if(rec.get("groupWeeks"))
					{
					var weekNumber = Ext.Date.format(Dt, "W Y");
					
					var DateFrom = Ext.Date.parse(weekNumber, "W Y");
					var DateTo = Ext.Date.add(DateFrom, Ext.Date.DAY, 7);
					
					return Ext.Date.format(DateFrom, "d.m.Y") + " – " + Ext.Date.format(DateTo, "d.m.Y");
					}
					else if(rec.get("groupAll"))
					{
					var DateTo = new Date();
					return Ext.Date.format(Dt, "d.m.Y") + " – " + Ext.Date.format(DateTo, "d.m.Y");
					}
					else return Ext.Date.format(Dt, "m.Y");
				}
			}
		],
		proxy:
		{
		type: 'ajax',
			extraParams:
			{
			detalization: "По дням",
			date: "Месяц"
			},
			api:
			{
			read: '_api/Seo/SeoAdminController/read/'
			},
			reader:
			{
			type: 'json',
			rootProperty: "data",
			messageProperty: "errortype"
			}
		}
	}
);