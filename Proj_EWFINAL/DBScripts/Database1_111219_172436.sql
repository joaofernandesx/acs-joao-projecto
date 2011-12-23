-- REL FK: defaultGroups [DefaultModule2Group]
alter table `group`   add index fk_group_module (`module_oid`), add constraint fk_group_module foreign key (`module_oid`) references `module` (`oid`);


-- REL FK: modules [Group2Module]
alter table `group_module`   add index fk_group_module_group (`group_oid`), add constraint fk_group_module_group foreign key (`group_oid`) references `group` (`oid`);


-- REL FK: groups [Module2Group]
alter table `group_module`   add index fk_group_module_module (`module_oid`), add constraint fk_group_module_module foreign key (`module_oid`) references `module` (`oid`);


-- REL FK: defaultUsers [DefaultGroup2User]
alter table `user`   add index fk_user_group (`group_oid`), add constraint fk_user_group foreign key (`group_oid`) references `group` (`oid`);


-- REL FK: groups [User2Group]
alter table `user_group`   add index fk_user_group_user (`user_oid`), add constraint fk_user_group_user foreign key (`user_oid`) references `user` (`oid`);


-- REL FK: users [Group2User]
alter table `user_group`   add index fk_user_group_group (`group_oid`), add constraint fk_user_group_group foreign key (`group_oid`) references `group` (`oid`);


-- REL FK: DocumentoToCategoriaDoc [rel8#role15]
alter table `documento_categoriadoc`   add index fk_categoriadoc_documento (`documento_iddoc`), add constraint fk_categoriadoc_documento foreign key (`documento_iddoc`) references `documento` (`iddoc`);


-- REL FK: CategoriaDocToDocumento [rel8#role16]
alter table `documento_categoriadoc`   add index fk_documento_categoriadoc (`categoriadoc_oid`), add constraint fk_documento_categoriadoc foreign key (`categoriadoc_oid`) references `categoriadoc` (`oid`);


-- REL FK: DocumentoToUser [rel9#role17]
alter table `documento_user`   add index fk_user_documento (`documento_iddoc`), add constraint fk_user_documento foreign key (`documento_iddoc`) references `documento` (`iddoc`);


-- REL FK: UserToDocumento [rel9#role18]
alter table `documento_user`   add index fk_documento_user (`user_oid`), add constraint fk_documento_user foreign key (`user_oid`) references `user` (`oid`);


