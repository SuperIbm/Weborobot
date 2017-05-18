Ext.define('Infoblock.component.get.model.InfoblockSelect',
	{
    extend: 'Ext.data.Model',
	name: 'InfoblockSelect',
	
	idProperty: 'idInfoblock',
	clientIdProperty: "idInfoblock",
	
    	fields:
		[			
			{
			name: "idInfoblock",
			type: "int"
			},
			{
			name: "labelInfoblock",
			type: "string"
			}
		],
		proxy:
		{
		type: 'ajax',
			api:
			{
			read: '_api/Infoblock/InfoblockAdminController/read/'
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