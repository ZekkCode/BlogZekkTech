<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $user = User::first();
    if (!$user) {
      $user = User::factory()->create([
        'name' => 'Admin',
        'email' => 'admin@example.com',
      ]);
    }

    $posts = [
      [
        'title' => 'Markdown Extended Features',
        'category' => 'Markdown',
        'excerpt' => 'Read more about Markdown features in Fuwari',
        'body' => '# Markdown Extended Features

Markdown is a lightweight markup language that you can use to add formatting elements to plaintext text documents. 

## Basic Syntax

### Headings

```markdown
# Heading 1
## Heading 2
### Heading 3
#### Heading 4
##### Heading 5
###### Heading 6
```

### Bold and Italic

```markdown
**Bold text**
*Italic text*
***Bold and Italic text***
```

### Lists

```markdown
- Item 1
- Item 2
  - Subitem 1
  - Subitem 2
  
1. First item
2. Second item
3. Third item
```

### Links

```markdown
[Link text](https://www.example.com)
```

### Images

```markdown
![Alt text](image.jpg)
```

## Extended Features

### Tables

```markdown
| Header 1 | Header 2 |
|----------|----------|
| Cell 1   | Cell 2   |
| Cell 3   | Cell 4   |
```

### Code Blocks

````markdown
```javascript
function greet() {
  console.log("Hello, world!");
}
```
````

### Task Lists

```markdown
- [x] Task 1 (completed)
- [ ] Task 2 (incomplete)
- [ ] Task 3 (incomplete)
```'
      ],
      [
        'title' => 'Expressive Code Example',
        'category' => 'Examples',
        'excerpt' => 'How code blocks look in Markdown using Expressive Code.',
        'body' => '# Expressive Code Example

Expressive Code is a powerful way to display code in your markdown documents with enhanced styling and features.

## Basic Example

```javascript
// This is a JavaScript function
function sayHello(name) {
  console.log(`Hello, ${name}!`);
  return `Hello, ${name}!`;
}

// Call the function
sayHello("World");
```

## Features

### Syntax Highlighting

```python
def calculate_factorial(n):
    """Calculate the factorial of a number"""
    if n == 0 or n == 1:
        return 1
    else:
        return n * calculate_factorial(n - 1)

# Calculate factorial of 5
result = calculate_factorial(5)
print(f"Factorial of 5 is {result}")
```

### Line Numbers

```css
/* With line numbers */
body {
  font-family: "Arial", sans-serif;
  margin: 0;
  padding: 0;
  background-color: #f5f5f5;
  color: #333;
}

header {
  background-color: #2c3e50;
  color: white;
  padding: 1rem;
  text-align: center;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 1rem;
}
```

### Frame and Title

```html title="index.html"
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Website</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <header>
    <h1>Welcome to My Website</h1>
  </header>
  
  <div class="container">
    <p>This is a simple example.</p>
  </div>
  
  <script src="script.js"></script>
</body>
</html>
```'
      ],
      [
        'title' => 'Simple Guides for Fuwari',
        'category' => 'Guides',
        'excerpt' => 'How to use this blog template.',
        'body' => '# Simple Guides for Fuwari

This guide will help you get started with using the Fuwari blog template.

## Getting Started

1. Clone the repository
2. Install dependencies
3. Customize the configuration
4. Add your content
5. Deploy

## Configuration

The main configuration file is located at `src/config.js`. You can modify it to change the site title, description, and other settings.

```javascript
// config.js
export default {
  // Site title
  title: "My Blog",
  
  // Site description
  description: "A blog about my thoughts and experiences",
  
  // Your name
  author: "John Doe",
  
  // Social media links
  social: {
    twitter: "https://twitter.com/yourusername",
    github: "https://github.com/yourusername",
    linkedin: "https://linkedin.com/in/yourusername"
  }
}
```

## Adding Content

To add a new blog post, create a new markdown file in the `src/content` directory. The file should have a frontmatter section with metadata about the post.

```markdown
---
title: My First Post
date: 2023-01-01
tags: [blog, markdown]
image: /images/my-post.jpg
---

# My First Post

This is my first blog post using Fuwari!
```

## Customizing Styles

You can customize the styles by editing the CSS files in the `src/styles` directory.'
      ],
      [
        'title' => 'Markdown Example',
        'category' => 'Examples',
        'excerpt' => 'A simple example of a Markdown blog post.',
        'body' => '# Markdown Example

This is a simple example of a Markdown blog post.

## Headings

You can use headings to structure your content:

# Heading 1
## Heading 2
### Heading 3
#### Heading 4
##### Heading 5
###### Heading 6

## Text Formatting

You can format text in various ways:

- **Bold text** using `**bold**`
- *Italic text* using `*italic*`
- ~~Strikethrough~~ using `~~strikethrough~~`
- `Code` using backticks

## Lists

### Unordered Lists

- Item 1
- Item 2
  - Subitem 2.1
  - Subitem 2.2
- Item 3

### Ordered Lists

1. First item
2. Second item
3. Third item

## Links

[Visit Google](https://www.google.com)

## Images

![Sample Image](https://via.placeholder.com/600x400)

## Blockquotes

> This is a blockquote.
> It can span multiple lines.

## Code Blocks

```javascript
function greet() {
  console.log("Hello, world!");
}
```

## Tables

| Name    | Age | Occupation  |
|---------|-----|-------------|
| John    | 28  | Developer   |
| Sarah   | 32  | Designer    |
| Michael | 41  | Manager     |

## Horizontal Rule

---

## Task Lists

- [x] Write the blog post
- [x] Format it with Markdown
- [ ] Publish it on the blog'
      ],
      [
        'title' => 'Include Video in the Posts',
        'category' => 'Tutorials',
        'excerpt' => 'This post demonstrates how to include embedded video in a blog post.',
        'body' => '# Include Video in the Posts

This post demonstrates how to include embedded video in a blog post.

## Using YouTube Embeds

You can embed a YouTube video using an iframe:

```html
<iframe width="560" height="315" src="https://www.youtube.com/embed/dQw4w9WgXcQ" 
frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; 
gyroscope; picture-in-picture" allowfullscreen></iframe>
```

Which will render like this:

<div class="aspect-w-16 aspect-h-9">
  <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" 
  frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; 
  gyroscope; picture-in-picture" allowfullscreen></iframe>
</div>

## Using Vimeo Embeds

Similarly, you can embed Vimeo videos:

```html
<iframe src="https://player.vimeo.com/video/123456789" 
width="640" height="360" frameborder="0" allow="autoplay; fullscreen; 
picture-in-picture" allowfullscreen></iframe>
```

## Local Video Files

You can also include video files hosted on your server:

```html
<video width="100%" controls>
  <source src="/videos/sample-video.mp4" type="video/mp4">
  Your browser does not support the video tag.
</video>
```

## Tips for Video Embeds

1. Always make your videos responsive by using CSS
2. Consider lazy loading videos for performance
3. Provide a poster/thumbnail for videos
4. Add captions or transcripts for accessibility'
      ]
    ];

    foreach ($posts as $index => $postData) {
      $category = Category::where('name', $postData['category'])->first();

      if ($category) {
        $post = Post::create([
          'user_id' => $user->id,
          'title' => $postData['title'],
          'slug' => Str::slug($postData['title']),
          'excerpt' => $postData['excerpt'],
          'body' => $postData['body'],
          'published_at' => now()->subDays($index),
        ]);

        // Attach category using many-to-many relationship
        $post->categories()->attach($category->id);
      }
    }
  }
}
