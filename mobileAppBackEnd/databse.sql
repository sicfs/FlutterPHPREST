CREATE TABLE IF NOT EXISTS `dersler` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dersAdi` varchar(256) NOT NULL,
  `dersKisaBaslik` text NOT NULL,
  `dersKucukResim` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

INSERT INTO `dersler` (`id`, `dersAdi`, `dersKisaBaslik`, `dersKucukResim`) VALUES
(1,  'Ders1', 'Led yakma söndürme',         'https://picsum.photos/200'),
(2,  'Ders2', 'Python Değişken türleri',    'https://picsum.photos/200'),
(3,  'Ders3', 'Simple Present Tense',       'https://picsum.photos/200'),
(44, 'Ders4', 'DC Motor Kullanimi',         'https://picsum.photos/200'),
(45, 'Ders5', 'Listening',                  'https://picsum.photos/200'),
(7,  'Ders6', 'Abilities and Animals can',  'https://picsum.photos/200');





