<?php

class AzubiSite extends Website
{
    public function getTitle()
    {
        $id = $this->getRequestParameter("id");
        $azubi = new Azubi($id);
        return $azubi->getName();
    }

    public function getAzubi()
    {
        $id = $this->getRequestParameter("id", 2);
        return new Azubi($id);
    }

    public function getPictureUrl($url)
    {
        if (empty($url)) {
            return "https://secure.gravatar.com/avatar/cb665e6a65789619c27932fc7b51f8dc?default=mm&size=200&rating=G";
        }
        return $url;
    }

    public function atFatchipSince($startDay, $startMonth, $startYear)
    {
        $day = date("d") - $startDay;
        if ($day < 0) {
            $day = 30 - $day;
        }
        $month = date("m");
        if ($month < $startMonth) {
            $month = date("m") + (12 - $startMonth);
        } else {
            $month = date("m") - $startMonth;
        }
        $year = date("Y") - $startYear;
        if ($month > $startMonth && $year != 0) {
            $year -= 1;
        }

        if ($year == 0 && $month == 0) {
            return "Bei Fatchip angestellt seit " . $day . " Tagen.";
        }
        if ($year == 0) {
            return "Bei Fatchip angestellt seit " . $month . " Monaten und " . $day . " Tagen.";
        }
        return "Bei Fatchip angestellt seit " . $year . " Jahren, " . $month . " Monaten und " . $day . " Tagen.";
    }
}