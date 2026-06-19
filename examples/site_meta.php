<?php

/**
 * 站点元信息管理示例
 * 
 * 该文件演示了如何使用数组存储网站元数据，
 * 并提供了一个生成简短描述文本的简易方法。
 */

// ---------------------------------------------------------------------------
// 配置常量：站点基础信息
// ---------------------------------------------------------------------------
define('SITE_URL', 'https://cnofficial-aiyouxi.com.cn');
define('SITE_KEYWORD', '爱游戏');

// ---------------------------------------------------------------------------
// 获取站点元信息数组
// ---------------------------------------------------------------------------
function getSiteMetaData(): array
{
    return [
        'site_name'        => '爱游戏官方社区',
        'site_url'         => SITE_URL,
        'site_keywords'    => [SITE_KEYWORD, '游戏资讯', '玩家交流', '游戏攻略'],
        'site_description' => '爱游戏官方社区，提供最新游戏资讯、攻略与玩家交流平台。',
        'author'           => '爱游戏团队',
        'language'         => 'zh-CN',
        'charset'          => 'UTF-8',
        'version'          => '1.0.0',
        'last_updated'     => date('Y-m-d'),
    ];
}

// ---------------------------------------------------------------------------
// 生成简短描述文本（用于 SEO、分享卡片等）
// ---------------------------------------------------------------------------
function generateShortDescription(array $meta, int $maxLength = 120): string
{
    // 优先使用已定义的描述，并截取合适长度
    $description = $meta['site_description'] ?? '';
    
    if (mb_strlen($description, 'UTF-8') > $maxLength) {
        $description = mb_substr($description, 0, $maxLength - 3, 'UTF-8') . '...';
    }
    
    // 如果描述为空，则基于关键词生成
    if (empty($description)) {
        $keywords = $meta['site_keywords'] ?? [];
        $keywordStr = implode('、', array_slice($keywords, 0, 5));
        $description = '这是一个关于' . $keywordStr . '的网站。';
        
        if (mb_strlen($description, 'UTF-8') > $maxLength) {
            $description = mb_substr($description, 0, $maxLength - 3, 'UTF-8') . '...';
        }
    }
    
    return $description;
}

// ---------------------------------------------------------------------------
// 获取 HTML <meta> 标签字符串（安全转义后）
// ---------------------------------------------------------------------------
function getMetaTags(array $meta): string
{
    $tags = '';
    
    $tags .= '<meta charset="' . htmlspecialchars($meta['charset'] ?? 'UTF-8', ENT_QUOTES, 'UTF-8') . '" />' . "\n";
    $tags .= '<meta name="description" content="' . htmlspecialchars(generateShortDescription($meta), ENT_QUOTES, 'UTF-8') . '" />' . "\n";
    
    $keywords = $meta['site_keywords'] ?? [];
    if (count($keywords) > 0) {
        $tags .= '<meta name="keywords" content="' . htmlspecialchars(implode(', ', $keywords), ENT_QUOTES, 'UTF-8') . '" />' . "\n";
    }
    
    $tags .= '<meta name="author" content="' . htmlspecialchars($meta['author'] ?? '', ENT_QUOTES, 'UTF-8') . '" />' . "\n";
    $tags .= '<meta name="language" content="' . htmlspecialchars($meta['language'] ?? 'zh-CN', ENT_QUOTES, 'UTF-8') . '" />' . "\n";
    
    return $tags;
}

// ---------------------------------------------------------------------------
// 示例使用
// ---------------------------------------------------------------------------
$siteMeta = getSiteMetaData();

echo "站点名称: " . $siteMeta['site_name'] . "\n";
echo "站点 URL: " . $siteMeta['site_url'] . "\n";
echo "简短描述: " . generateShortDescription($siteMeta) . "\n";
echo "\n--- HTML Meta 标签 ---\n";
echo getMetaTags($siteMeta);