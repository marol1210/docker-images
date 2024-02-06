# docker-images

## 说明

`基于laravel开发电商CRM系统. 系统功能以laravel包的的形式提供.`

## 系统运行要求

    Docker
    PHP8.1
    MariaDB
    Redis
    Laravel:~10.0

## 运行方式

    cd laravel
    docker compose up -d #创建laravel应用容器，监听端口：80

## 模块

`admin-base`

##### 功能模块
- #####  商品管理
  - 商品类别
  - 商品列表
- #####  系统管理
  - 账号管理
  - 角色管理
- #####  系统登录