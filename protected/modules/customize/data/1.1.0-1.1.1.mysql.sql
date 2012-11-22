ALTER TABLE `{{CmsArticle}}` ADD `editorType` tinyint unsigned;
ALTER TABLE `{{CmsPage}}` ADD `editorType` tinyint unsigned;
ALTER TABLE `{{CmsBlock}}` ADD `editorType` tinyint unsigned, ADD `getParams` varchar(250);