-- Group [Group]
create table `group` (
   `oid`  integer  not null,
   `groupname`  varchar(255),
  primary key (`oid`)
);


-- Module [Module]
create table `module` (
   `oid`  integer  not null,
   `moduleid`  varchar(255),
   `modulename`  varchar(255),
  primary key (`oid`)
);


-- User [User]
create table `user` (
   `oid`  integer  not null,
   `username`  varchar(255),
   `password`  varchar(255),
   `email`  varchar(255),
  primary key (`oid`)
);


-- Documento [ent1]
create table `documento` (
   `iddoc`  integer  not null,
   `titulo`  varchar(255),
   `path_file`  varchar(255),
   `datacriacao`  date,
   `datamodificacao`  date,
   `keywords`  varchar(255),
   `public`  bit,
  primary key (`iddoc`)
);


-- CategoriaDoc [ent2]
create table `categoriadoc` (
   `oid`  integer  not null,
   `descricao`  varchar(255),
  primary key (`oid`)
);


-- Group_DefaultModule [Group2DefaultModule_DefaultModule2Group]
alter table `group`  add column  `module_oid`  integer;
alter table `group`   add index fk_group_module (`module_oid`), add constraint fk_group_module foreign key (`module_oid`) references `module` (`oid`);


-- Group_Module [Group2Module_Module2Group]
create table `group_module` (
   `group_oid`  integer not null,
   `module_oid`  integer not null,
  primary key (`group_oid`, `module_oid`)
);
alter table `group_module`   add index fk_group_module_group (`group_oid`), add constraint fk_group_module_group foreign key (`group_oid`) references `group` (`oid`);
alter table `group_module`   add index fk_group_module_module (`module_oid`), add constraint fk_group_module_module foreign key (`module_oid`) references `module` (`oid`);


-- User_DefaultGroup [User2DefaultGroup_DefaultGroup2User]
alter table `user`  add column  `group_oid`  integer;
alter table `user`   add index fk_user_group (`group_oid`), add constraint fk_user_group foreign key (`group_oid`) references `group` (`oid`);


-- User_Group [User2Group_Group2User]
create table `user_group` (
   `user_oid`  integer not null,
   `group_oid`  integer not null,
  primary key (`user_oid`, `group_oid`)
);
alter table `user_group`   add index fk_user_group_user (`user_oid`), add constraint fk_user_group_user foreign key (`user_oid`) references `user` (`oid`);
alter table `user_group`   add index fk_user_group_group (`group_oid`), add constraint fk_user_group_group foreign key (`group_oid`) references `group` (`oid`);


-- Documento_CategoriaDoc [rel8]
alter table `documento`  add column  `categoriadoc_oid`  integer;
alter table `documento`   add index fk_documento_categoriadoc (`categoriadoc_oid`), add constraint fk_documento_categoriadoc foreign key (`categoriadoc_oid`) references `categoriadoc` (`oid`);


-- Documento_User [rel9]
alter table `documento`  add column  `user_oid`  integer;
alter table `documento`   add index fk_documento_user (`user_oid`), add constraint fk_documento_user foreign key (`user_oid`) references `user` (`oid`);


