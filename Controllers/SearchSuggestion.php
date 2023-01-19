<?php

class SearchSuggestion extends JsonController
{
    protected function getJsonData()
    {
       return $this->getAzubiNames();
    }


    public function getAzubiNames($size = 10) {
        $filter = trim($this->getRequestParameter("filter", ""));
        $sql = "SELECT name FROM azubi";
        if ($filter != "") {
            $sql .= " WHERE name LIKE '%".$filter."%' LIMIT " . $size;
        }

        $names = [];
        $result = DatabaseConnection::executeMysqlQuery($sql);
        while ($row = mysqli_fetch_row($result)) {
            $name = $row[0];
            $name = $this->wrapTextWithTags($name, $filter, "strong");
            $names[] = $name;
        }
        return $names;
    }

    protected function wrapTextWithTags( $haystack, $needle , $tag ): string
    {
        $lowerHaystack = strtolower($haystack);
        $lowerNeedle = strtolower($needle);

        $start = stripos($lowerHaystack, $lowerNeedle);
        $length = strlen($needle);

        $textPart = substr($haystack, $start, $length);
        $boldPart = "<" . $tag . ">" . $textPart . "</" . $tag . ">";

        return str_replace($textPart, $boldPart, $haystack);
    }
}