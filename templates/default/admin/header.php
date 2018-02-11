<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>{$_G[title]}-后台管理中心</title>
    <meta name="keywords" content="{$_G[keywords]}">
    <meta name="description" content="{$_G[description]}">
    <meta name="render" content="webkit">
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="icon" href="/static/images/common/favicon.png">
    <link rel="stylesheet" type="text/css" href="/static/css/admin.css?{TIMESTAMP}">
    <script src="/static/js/jquery.js" type="text/javascript"></script>
    <script src="/static/js/common.js" type="text/javascript"></script>
    <script>var myData = {echo json_encode($this->member)};</script>
</head>
<body style="padding: 20px;">
