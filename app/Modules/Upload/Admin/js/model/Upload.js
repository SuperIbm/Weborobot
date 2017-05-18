Ext.define('Upload.model.Upload',
	{
    extend: 'Ext.data.Model',
	name: 'Upload',
	idProperty: 'idUpload',
	clientIdProperty: "idUpload",
	
    	fields:
		[
            {
			name: "idUpload",
			type: "int"
            },
			{
			name: "idModule",
			type: "int"
			},
			{
			name: "labelModule",
			mapping: 'module.labelModule',
			type: "string"
			},
            {
            name: "currentDate",
            mapping: 'module.currentDate',
            type: "date",
            dateFormat: "Y-m-d"
            },
			{
			name: "currentVersion",
            mapping: 'module.currentVersion',
			type: "string"
			},
            {
            name: "nextDate",
            type: "date",
            dateFormat: "Y-m-d H:i:s"
            },
			{
			name: "nextVersion",
			type: "string"
			}
		],
		proxy:
		{
		type: 'ajax',
		noCache: false,
			api:
			{
            read: '_api/Upload/UploadAdminController/read/'
			},
			reader:
			{
			type: 'json',
			rootProperty: "data",
			messageProperty: "errortype"
			},
			writer:
			{
			type: 'cgi',
			writeAllFields: true
			}
		}
	}
);