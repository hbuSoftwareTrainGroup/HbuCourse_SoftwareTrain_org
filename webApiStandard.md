### 管理员登录
js->php:
名称|类型|含义
---|:--:|---:
username|char|用户名
password|char|密码

php->js:
名称|类型|含义
---|:--:|---:
code|int|返回码（200为操作成功，503 为操作失败）
state|char|返回的详细信息
*****

### 影碟入库
js->php:
名称|类型|含义
---|:--:|---:
position|char|影碟存放位置
price|double|影碟价格
video_name|char|影碟名称
lead_actor|char|主演
stock|int|现存张数
input_goods|int|进货张数
serial_number|char|影碟编号

php->js:
名称|类型|含义
---|:--:|---:
code|int|返回码（200为入库成功，503 为操作失败）
state|char|返回的详细信息
*****

### 影碟更新
js->php:
名称|类型|含义
---|:--:|---:
position|char|影碟存放位置
price|double|影碟价格
video_name|char|影碟名称
lead_actor|char|主演
stock|int|现存张数
input_goods|int|进货张数

php->js:
名称|类型|含义
---|:--:|---:
code|int|返回码（200为操作成功，503 为操作失败）
state|char|返回的详细信息
*****
### 影碟删除
js->php:
名称|类型|含义
---|:--:|---:
video_disk_id|int|影碟的id

php->js:
名称|类型|含义
---|:--:|---:
code|int|返回码（200为操作成功，503 为操作失败）
state|char|返回的详细信息
*****

### 按片名查询
js->php:
名称|类型|含义
---|:--:|---:
video_name|char|片名
mark|int|查询类型（片名-1；影片编号-2；主演姓名-3）

php->js:
名称|类型|含义
---|:--:|---:
position|char|影碟存放位置
price|double|影碟价格
video_name|char|影碟名称
lead_actor|char|主演
stock|int|现存张数
serial_number|char|影碟编号
code|int|返回码（200为操作成功，503 为操作失败）
state|char|返回的详细信息
*****

### 按影片编号查询
js->php:
名称|类型|含义
---|:--:|---:
serial_number|char|影碟编号
mark|int|查询类型（片名-1；影片编号-2；主演姓名-3）

php->js:
名称|类型|含义
---|:--:|---:
position|char|影碟存放位置
price|double|影碟价格
video_name|char|影碟名称
lead_actor|char|主演
stock|int|现存张数
serial_number|char|影碟编号
code|int|返回码（200为操作成功，503 为操作失败）
state|char|返回的详细信息
*****

### 按主演姓名查询
js->php:
名称|类型|含义
---|:--:|---:
lead_actor|char|主演姓名
mark|int|查询类型（片名-1；影片编号-2；主演姓名-3）

php->js:
名称|类型|含义
---|:--:|---:
count|int|查询到的数量
position|char|影碟存放位置
price|double|影碟价格
video_name|char|影碟名称
lead_actor|char|主演
stock|int|现存张数
serial_number|char|影碟编号
code|int|返回码（200为操作成功，503 为操作失败）
state|char|返回的详细信息
*****

### 影碟预览
js->php:
名称|类型|含义
---|:--:|---:
video_disk_id|int|影碟的id

php->js:
名称|类型|含义
---|:--:|---:
code|int|返回码（200为操作成功，503 为操作失败）
state|char|返回的详细信息
*****