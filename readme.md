# Laravel OpenAI Generator Created By Mayanksing 

A Laravel 11+ compatible package to integrate **OpenAI GPT (text generation)** and **DALL·E (image generation)** APIs in your Laravel projects.

Supports:
- ✅ Text generation using GPT-4 / GPT-3.5
- 🖼️ Image generation using OpenAI DALL·E

---

## 📦 Installation

### 1. Download & Extract

Download the package and place it inside your Laravel app at: packages/mayanksinh/laravel-openai-generator

### 2. Update `composer.json` of Laravel app
"repositories": [
    {
        "type": "path",
        "url": "packages/mayanksinh/laravel-openai-generator"
    }
],
"require": {
    "mayanksinh/laravel-openai-generator": "*"
}

### Then run: 
composer update

### 3. Publish the config : 
php artisan vendor:publish --tag="openai-config"

### 4. Add API key to .env
OPENAI_API_KEY=your-openai-api-key
OPENAI_MODEL=gpt-4

### Methods :
generateText($prompt)	: Generate AI-powered text
generateImage($prompt)	: Generate AI-generated image URLs

### Requirements
Laravel 11+
PHP 8.2+
Guzzle HTTP Client

###  Example Routes
Route::get('/text', function () {
    return OpenAI::generateText("Give a one-line Laravel tip.");
});

Route::get('/image', function () {
    return OpenAI::generateImage("A robotic hand holding a flower");
});
