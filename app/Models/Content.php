<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $fillable = ['cat_id', 'title_id', 'year', 'text', 'slug'];
    protected $table = 'content';

    public function category()
    {
        return $this->belongsTo(Category::class, 'cat_id');
    }

    public function lemma()
    {
        return $this->belongsTo(Lemma::class, 'title_id');
    }

    public function media()
    {
        return $this->hasMany(Media::class, 'content_id');
    }

    /**
     * Get formatted text content
     */
    public function getFormattedTextAttribute()
    {
        // Decode HTML entities if content is double-encoded
        $text = html_entity_decode($this->text, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        // If still contains encoded entities, decode again
        if (strpos($text, '&lt;') !== false || strpos($text, '&gt;') !== false) {
            $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        }

        // Fix encoding issues in text content
        $text = str_replace('â€"', '—', $text); // En dash
        $text = str_replace('â€"', '—', $text); // Em dash
        $text = str_replace('â€¦', '—', $text); // Ellipsis
        $text = str_replace('â€™', "—", $text); // Right single quotation mark
        $text = str_replace('â€œ', '—', $text); // Left double quotation mark
        $text = str_replace('â€', '—', $text); // Right double quotation mark
        
        // Clean up any remaining encoding artifacts
        $text = mb_convert_encoding($text, 'UTF-8', 'UTF-8');
        
        // Remove quotes that appear immediately before or after dashes in number ranges
        // Pattern: digit + quote + dash or dash + quote + digit
        $text = preg_replace("/(\d)[\"']+([–—])/u", '$1$2', $text); // Remove quotes before dash after number
        $text = preg_replace("/([–—])[\"']+(\d)/u", '$1$2', $text); // Remove quotes after dash before number
        
        return $text;
    }

    /**
     * Get formatted year
     */
    public function getFormattedYearAttribute()
    {
        if (!$this->year) {
            return null;
        }

        $year = $this->year;

        // First, extract only digits to check for concatenated years
        $digitsOnly = preg_replace('/\D/', '', $year);

        // Handle concatenated years (e.g., "19271995" → "1927–1995")
        // Pattern: exactly 8 digits (4 digits + 4 digits)
        if (strlen($digitsOnly) === 8) {
            $year1 = substr($digitsOnly, 0, 4);
            $year2 = substr($digitsOnly, 4, 4);
            $currentYear = (int) date('Y');

            // Only format if both years are reasonable (between 1000 and current year + 10)
            if (
                $year1 >= 1000 && $year1 <= ($currentYear + 10) &&
                $year2 >= 1000 && $year2 <= ($currentYear + 10) &&
                $year2 >= $year1
            ) {
                return $year1 . '–' . $year2;
            }
        }

        // Fix encoding issues (â€" → –, â€" → —, etc.)
        $year = str_replace('â€"', '–', $year); // En dash
        $year = str_replace('â€"', '—', $year); // Em dash
        $year = str_replace('â€¦', '…', $year); // Ellipsis
        $year = str_replace('â€™', "'", $year); // Right single quotation mark
        $year = str_replace('â€œ', '"', $year); // Left double quotation mark
        $year = str_replace('â€', '"', $year); // Right double quotation mark

        // Clean up any remaining encoding artifacts
        $year = mb_convert_encoding($year, 'UTF-8', 'UTF-8');

        // Remove any non-printable characters except dashes, spaces, dots, and numbers
        $year = preg_replace('/[^\d\s\–\—\-\.]/u', '', $year);

        // Trim whitespace
        $year = trim($year);

        return $year ?: $this->year;
    }
}