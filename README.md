API Document
===

* Monsters
    * **api/GetMonsters/{index}**
    	* **Description**
            取得Monster資料。
        * **Method**: ++GET++
        * **Parameter**:
            * index: int
                :::info
                直接用ID進行選擇
                :::
    * **api/GetMonsters/{StartIndex}/{EndIndex}**
    	* **Description**
            取得Monster資料。
        * **Method**: ++GET++
        * **Parameter**:
            * StartIndex: int
                :::info
                從0開始
                :::
            * EndIndex: int
                :::info
                需大於等於StartIndex
                :::
    * **api/GetMonsters//{StartIndex}/{EndIndex}**
    	* **Description**
            取得Monster資料。
            同 **api/GetMonsters/{StartIndex}/{EndIndex}**
    * **api/GetMonsters/{fsString?}/{StartIndex?}/{EndIndex?}**
    	* **Description**
            取得Monster資料。
        * **Method**: ++GET++
        * **Parameter**:
            * fsString: string
                :::info
                對資料進行過濾和排序，每個參數用 **,** 做分隔。

                過濾參數
                 * Attributes: int
                 * id:{int}
                 * price:{low}-{high}

                排序參數
                 * newest 依建立時間由新到舊
                 * hottest 依賣出數量由多到少
                 * cheapest 依打折後的價格由少到多
                :::
            * StartIndex: int
                :::info
                從0開始
                :::
            * EndIndex: int
                :::info
                需大於等於StartIndex
                :::
    ```json*=
    {
        [
                 'id': int,
             'imgNum': int,
               'NAME': int,
            'NAME_EN': int,
            'NAME_JP': int,
         'attributes': object[{
                            'NAME': string,
                         'NAME_EN': string,
                         'NAME_JP': string
                       }],
                 'HP': int,
             'ATTACK': int,
            'DEFENSE': int,
              'SPEED': int,
          'SP_ATTACK': int,
         'SP_DEFENSE': int,
        'description': int,
           'discount': int,
              'price': int,
               'sold': int,
          'createdAt': Date,
        ]
    }
    ```
    * api/GetMonstersAmount/{fsString}
    	* **Description**
    		取得Monster數量。
        * **Method**: ++GET++
        * **Parameter**:
            * fsString: string
                同 GetMonsters 的 fsString
* Image
    * api/Image/{size}/{monId}
    	* **Description**
    		取得Monster圖片。
        * **Method**: ++GET++
        * **Parameter**:
            * size: int
                :::info
                圖片尺寸，寬等於高
                :::
            * monId: int
                :::info
                Monster ID
                :::
    * api/Image/{size}/{monId}/{imgId}
    	* **Description**
    		取得Monster圖片。
        * **Method**: ++GET++
        * **Parameter**:
            * size: int
                :::info
                圖片尺寸，寬等於高
                :::
            * monId: int
                :::info
                Monster ID
                :::
            * imgId: int
                :::info
                第幾張圖片，從0開始
                :::
    * api/Image/{width}/{height}/{monId}/{imgId}
    	* **Description**
    		取得Monster圖片。
        * **Method**: ++GET++
        * **Parameter**:
            * width: int
                :::info
                圖片的寬
                :::
            * height: int
                :::info
                圖片的高
                :::
            * monId: int
                :::info
                Monster ID
                :::
            * imgId: int
                :::info
                第幾張圖片，從0開始
                :::
* Auth
	* ==不須登入== api/register
		* **Description**
			註冊帳號
		* **Method**: ++POST++
		* **Parameter**:
			* name: string
			    :::info
                長度最大為255
                :::
            * email: string
			    :::info
                長度最大為255
                必須為E-mail格式
                :::
            * password: string
			    :::info
                長度最小為6
                :::
            * confirm_password: string
			    :::info
                長度最小為6
                必須和password一樣
                :::
    ```json*=
    //message struct
    {
        'key': string
    }
    //return
    {
         'status': bool,
        'message': message
    }
    ```
	* ==不須登入== api/login
		* **Description**
			登入帳號
		* **Method**: ++POST++
		* **Parameter**:
            * email: string
			    :::info
                長度最大為255
                必須為E-mail格式
                :::
            * password: string
			    :::info
                長度最小為6
                :::
    ```json*=
    //message struct
    {
        'key': string
    }
    //key struct
    {
             'token': string,
              'type': string,
        'expires_in': int
    }
    //return
    {
         'status': bool,
        'message': message
    }
    //when status = true
    {
         'status': true,
        'message': {
            'URL': string(ResetPasswordURL)
        }
    }
    ```
    * ==不須登入== api/forgetPwd
    	* **Description**
    		忘記密碼
    	* **Method**: ++POST++
    	* **Parameter**:
			* name: string
			    :::info
                長度最大為255
                :::
            * email: string
			    :::info
                長度最大為255
                必須為E-mail格式
                :::
    ```json*=
    //message struct
    {
        'key': string
    }
    //return
    {
         'status': bool,
        'message': message
    }
    ```
	* ==不須登入== api/reset
		* **Description**
			重設密碼
		* **Method**: ++POST++
		* **Parameter**:
            * email: string
			    :::info
                長度最大為255
                必須為E-mail格式
                :::
            * token: string
			    :::info
                長度最大為255
                :::
            * password: string
			    :::info
                長度最小為6
                :::
            * confirm_password: string
			    :::info
                長度最小為6
                必須和password一樣
                :::
    ```json*=
    //message struct
    {
        'key': string
    }
    //return
    {
         'status': bool,
        'message': message
    }
    ```
	* ==需登入== api/logout
		* **Description**
			登出
		* **Method**: ++POST++
    ```json*=
    //message struct
    {
        'key': string
    }
    //return
    {
         'status': bool,
        'message': message
    }
    ```
	* ==需登入== api/refresh
		* **Description**
			從設token
		* **Method**: ++POST++
    ```json*=
    //key struct
    {
             'token': string,
              'type': string,
        'expires_in': int
    }
    //return
    {
         'status': bool,
        'message': key
    }
    ```
	* ==需登入== api/user
		* **Description**
			取得用戶資料
		* **Method**: ++POST++
	```json*=
    {
                       'id': int,
               'permission': int,
                     'name': string,
                    'email': string,
        'email_verified_at': Date?,
               'created_at': Date,
               'updated_at': Date
    }
    ```
	* ==需登入== api/config
		* **Description**
			更新用戶資料
		* **Method**: ++POST++
		* **Parameter**:
            * name: string
			    :::info
                長度最大為255
                :::
            * password: string
			    :::info
                長度最小為6
                :::
            * confirm_password: string
			    :::info
                長度最小為6
                必須和password一樣
                :::
    ```json*=
    //message struct
    {
        'key': string
    }
    //return
    {
        'status' => bool,
        'message' => message
    }
    ```
* Cart
	* api/GetCart
		* **Description**
			取得購物車
        * **Method**: ++GET++
    ```json*=
    //message struct
    {
        'key': string
    }
    //cart struct
    {
        'ProductId': int,
            'Count': int
    }
    //return
    {
        'status' => bool,
        'message' => message,
        'cart' => cart[]
    }
    ```
	* api/GetOrders
		* **Description**
			取得訂單資料
        * **Method**: ++GET++
    ```json*=
    //message struct
    {
        'key': string
    }
    //order struct
    {
        'ProductId': int,
            'Count': int,
            'Price': int
    }
    //return
    {
        'status' => bool,
        'message' => message,
        'order' => order[]
    }
    ```
	* api/UpdateCart
		* **Description**
			更新購物車
        * **Method**: ++POST++
		* **Parameter**:
		    * cart: array
		        :::info
                e.g. ```[{"ProductId": 1, "Count": 20}]```
                :::
    ```json*=
    //message struct
    {
        'key': string
    }
    //return
    {
        'status' => bool,
        'message' => message
    }
    ```
	* api/MakeOrder
		* **Description**
			下訂單
        * **Method**: ++POST++
		* **Parameter**:
		    * Address: string
		        :::info
                地址
                :::
    ```json*=
    //message struct
    {
        'key': string
    }
    //return
    {
        'status' => bool,
        'message' => message
    }
    ```
 
