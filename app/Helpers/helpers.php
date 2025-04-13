<?php

function highlightWords($content, $violations = [])
{
    if (empty($violations) || ! is_array($violations)) {
        return $content;
    }

    foreach ($violations as $violation) {
        $pattern = '/\b('.preg_quote($violation, '/').')\b/i';
        $content = preg_replace(
            $pattern,
            '<span style="background: #ffcccc; color: red; padding: 2px;">$1</span>',
            $content
        );
    }

    return $content;
}


if (!function_exists('time_ago')) {
    /**
     * Chuyển đổi thời gian thành dạng "time ago"
     *
     * @param string $created_at Ngày giờ tạo bài viết (hoặc sự kiện)
     * @return string Thời gian cách thời điểm hiện tại (ví dụ: "2 ngày", "3 giờ")
     */
    function time_ago($created_at)
    {
        $current_time = new DateTime();
        $created_at = new DateTime($created_at);
        $interval = $current_time->diff($created_at);

        if ($interval->y > 0) {
            return $interval->y . ' năm';
        } elseif ($interval->m > 0) {
            return $interval->m . ' tháng';
        } elseif ($interval->d > 0) {
            return $interval->d . ' ngày';
        } elseif ($interval->h > 0) {
            return $interval->h . ' giờ';
        } elseif ($interval->i > 0) {
            return $interval->i . ' phút';
        } else {
            return $interval->s . ' giây';
        }
    }
}