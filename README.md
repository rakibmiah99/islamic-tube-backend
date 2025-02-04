# Get All Videos Api 

### **API Endpoint: Get All Videos**

#### **URL**
`GET /api/videos`

#### **Request Parameters**

| Parameter | Type   | Description                          | Default |
|-----------|--------|--------------------------------------|---------|
| `limit`   | integer| Number of videos to retrieve.        | 24      |
| `offset`  | integer| Starting point for pagination.       | 0       |

---

#### **Response**

- **Status Code:** `200 OK`
- **Response Body:**
```json
  {
    "status": "success",
    "message": "",
    "figure": {
        "next_load": "http://127.0.0.1:8000/api/videos?offset=24",
        "query": {
            "limit": "24",
            "current_offset": "0",
            "next_offset": 24
        },
        "data": [
            {
                "title": "সূরা আল ফুরকান (سورة الفرقان) - সত্য মিথ্যার পার্থক্য নির্ধারণকারী",
                "slug": "et-quibusdam-voluptatem-nulla-in-voluptatem-possimus",
                "thumbnail": "https://thumbs.dreamstime.com/b/islamic-themed-youtube-thumbnail-modern-traditional-elements-engaging-backgrounds-beautiful-high-quality-youtube-340012414.jpg",
                "watch_count": 28,
                "published_at": "2019-04-21 14:14:42"
            },
            ...,
            ...
        ]
    }
}
  ```
  
  
### **API Endpoint: Video Details**

#### **URL**
`GET /api/video/{slug}`

---

#### **Response**

- **Status Code:** `200 OK`
- **Response Body:**
```json
  {
    "status": "success",
    "message": "",
    "figure": {
        "title": "সূরা আল ফুরকান (سورة الفرقان) - সত্য মিথ্যার পার্থক্য নির্ধারণকারী",
        "slug": "et-quibusdam-voluptatem-nulla-in-voluptatem-possimus",
        "thumbnail": "https://thumbs.dreamstime.com/b/islamic-themed-youtube-thumbnail-modern-traditional-elements-engaging-backgrounds-beautiful-high-quality-youtube-340012414.jpg",
        "description": null,
        "long_description": "Impedit et inventore sapiente ad aspernatur earum eius occaecati assumenda ipsum labore recusandae expedita qui nobis sint unde enim velit eligendi laborum perspiciatis facilis ad et enim qui dolor ab dolor quia repudiandae quos aut occaecati dolores ratione molestiae asperiores magnam aliquam fugiat omnis aspernatur libero omnis accusamus hic magni deleniti est sint molestiae porro voluptatem quidem officia sunt nostrum veniam qui omnis voluptate recusandae fugiat excepturi voluptas assumenda numquam ea a dolorum dignissimos odit maxime expedita quo eum illum et doloremque qui aut adipisci ea occaecati rerum fugit ullam consectetur similique enim autem asperiores nam esse ducimus voluptatem et voluptas omnis laborum possimus exercitationem eos omnis debitis reprehenderit ut voluptas sit ipsam cumque laboriosam possimus sint velit ea ut nostrum distinctio voluptatibus quis perferendis praesentium consequatur tempora libero id ex et architecto minus ut soluta est sed illum saepe odit ratione voluptate in ut velit dolorem nam qui delectus eligendi dolorum earum ducimus voluptas quo quaerat provident quo magni rerum minus ea quia quis consequatur qui quo id maiores dolorem non omnis sint occaecati repudiandae ducimus repellendus eligendi consequatur praesentium iusto distinctio sunt impedit fuga commodi impedit tenetur fuga delectus veniam nobis voluptatem occaecati et veritatis quos voluptatem aut cumque aspernatur aut distinctio neque quasi vel iure quisquam commodi nihil ut alias non expedita aliquam illo rerum magni incidunt itaque voluptates sapiente sint consectetur fuga laborum ut nulla laboriosam accusamus consequatur et quaerat dolorem qui ex esse asperiores quam et unde quae dolor commodi rerum et dolores quos excepturi ut et modi est tenetur dolores labore quis labore debitis voluptatem eaque eaque fugiat consequatur error nihil unde quisquam aut et quos temporibus est earum non earum et nobis non iure ullam iste quia saepe et commodi quisquam sint dolore esse rerum quod minima consequatur et unde non quia qui fuga placeat voluptas facere consequatur necessitatibus sit dolor animi exercitationem vitae itaque excepturi ab distinctio iure ducimus ipsum esse doloremque et quo rerum necessitatibus numquam tempore placeat consequatur et et in expedita neque rerum ea optio sint corrupti repudiandae inventore est similique accusamus non sapiente ab assumenda adipisci cum amet ipsum quia fuga adipisci est doloremque sunt id error asperiores suscipit et ut facere pariatur sed id et sunt iste pariatur et saepe rerum amet quod facere quos iure natus facilis suscipit fugit sequi aperiam magni magnam assumenda sit fugit qui provident quia nesciunt aperiam perferendis aut.",
        "video_url": "https://www.youtube.com/watch?v=fRaURh6Fjq4",
        "provider": "youtube",
        "published_at": "2019-04-21 14:14:42",
        "watch_count": 28,
        "related_videos": {
            "token": "zDlpPdbfKyF9rdT--QhAr6mYR9o3Ewv0eicgL5h54vk4=",
            "data": [
                {
                    "title": "এ আলোচনাটি আপনার নামাজ সম্পর্কে ধারণা বদলে দিতে পারে!",
                    "slug": "numquam-accusantium-non-dolorum-ipsa-a-assumenda",
                    "thumbnail": "https://static.vecteezy.com/system/resources/previews/035/380/973/non_2x/ai-generated-an-extravagant-brown-and-gold-background-with-intricate-geometric-designs-free-photo.jpg",
                    "watch_count": 30,
                    "published_at": "2000-10-07 13:28:13"
                },
                ...,
                ...,
            ]
        },
        "comments": {
            "token": "V5CDjnkWAv6e7v0RlE3--jA==",
            "data": [
                {
                    "id": 801,
                    "body": "Facere tenetur distinctio ut totam.",
                    "user": {
                        "name": "Vesta Moore"
                    }
                },
                ...,
                ...
            ]
        }
    }
  }
``` 

### **Load More Related Videos**

#### **URL**
`GET /api/video/{token}/more-related`

---

#### **Response**

- **Status Code:** `200 OK`
- **Response Body:**
```json
  {
    "status": "success",
    "message": "",
    "figure": {
        "token": "zDlpPdbfKyF9rdT--QhAr6scJ21R1j9TOoppSpqEQUSQ=",
        "data": [
            {
                "title": "বিপদের পরিক্ষিত ৪টি দোয়া,পড়লে আল্লাহর গায়েবী সাহায্য পাবেন",
                "slug": "et-culpa-sit-ut-soluta-quasi-dolor-quo",
                "thumbnail": "https://img.freepik.com/premium-vector/youtube-thumbnail-islamic-new-year-celebration_23-2150428737.jpg",
                "watch_count": 13,
                "published_at": "2003-10-14 10:30:15"
            },
            ...,
            ...
        ]
    }
  }
```

### **Load More Comments**

#### **URL**
`GET /api/video/{token}/more-comments`

---

#### **Response**

- **Status Code:** `200 OK`
- **Response Body:**
```json
  {
    "status": "success",
    "message": "",
    "figure": {
        "token": "fo1kvbPuBH005vSy9OHqIw==",
        "data": [
            {
                "id": 816,
                "body": "Sed ipsa illum dolor asperiores rem.",
                "user": {
                    "name": "Weston Nicolas"
                }
            },
            ...,
            ...
        ]
    }
  }
```


Here’s a well-structured API request documentation in a clean and readable format:

---

## **Create Comment In Video API**

### **Endpoint**
`POST /video/{slug}/comment`

### **Description**
This API allows users to post a comment on a video using its unique `slug`.

---

### **Headers**

| **Key**             | **Value**                          | **Required** |
|---------------------|----------------------------------|-------------|
| `Content-Type`     | `application/json`               | ✅          |
| `Authorization`    | `Bearer YOUR_ACCESS_TOKEN`       | ✅          |

### **Request Body**

| **Parameter** | **Type**  | **Description**         | **Required** |
|--------------|----------|-------------------------|-------------|
| `body`       | `string` | The text of the comment | ✅          |

#### **Example Request Body**
```json
{
  "body": "This is a comment."
}
```

---

### **Fetch API Request Example**
```js
fetch("https://yourapi.com/video/{slug}/comment", {
    method: "POST",
    headers: {
        "Content-Type": "application/json",
        "Authorization": "Bearer YOUR_ACCESS_TOKEN"
    },
    body: JSON.stringify({
        body: "This is a comment."
    })
}).then(response => response.json())
  .then(data => console.log("Comment created:", data))
  .catch(error => console.error("Error:", error));
```

---

### **Response Example (Success)**
```json
{
    "status": "success",
    "message": "Comment created!",
    "figure": {
        "id": 5005,
        "body": "this my first commet",
        "user": {
            "name": "MD Rakib Miah"
        }
    }
}
```

### **Notes**
- Replace `{slug}` in the URL with the actual video slug.
- Ensure the request includes a valid **Bearer Token** for authentication.
- If the token is missing or invalid, the request will return a **401 Unauthorized** error.

---
