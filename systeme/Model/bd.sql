

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `role` varchar(300) DEFAULT NULL,
  `token` tinytext NOT NULL,
  `pseudo` varchar(300) DEFAULT NULL,
  `email` varchar(300) DEFAULT NULL,
  `nom` varchar(300) DEFAULT NULL,
  `motdepasse` tinytext,
  `statut` varchar(100) DEFAULT NULL,
  `date_creation` varchar(200) NOT NULL,
  `telephone` varchar(200) NOT NULL,
  `photo` tinytext NOT NULL,
  `derniere_connection` varchar(200) NOT NULL,
  `verified` varchar(100) NOT NULL,
  `token_device` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `role`, `token`, `pseudo`, `email`, `nom`, `motdepasse`, `statut`, `date_creation`, `telephone`, `photo`, `derniere_connection`, `verified`, `token_device`) VALUES
(1, 'super-admin', '', 'fater04', 'wilker@solutionip.app', 'wilker dorvelus', '$2y$10$OgvZdD0ZMxDq3jhqdrON7.tZtKKJZNyE1QGhpmSRdf//amL05I4rO', 'oui', '2023-09-11 10:49:14', '31110731', 'n/a', '', '', ''),
(2, 'super-admin', '', 'j3ff', 'jmtuto@yahoo.com', 'jeff mathurin', '$2y$10$eiVMJxunMzHkXWa/7SRjtektr64ayAItdX15Z/Xn698CQBHJbbVTa', 'oui', '2023-09-11 10:49:14', '43760514', 'n/a', '', '', ''),
(3, 'super-admin', '', 'solutionip', 'gpetienne@innovatechsolutions.app', 'guy philippe etienne', '$2y$10$rlPx1jwIB1ngl6XU5LiA3ukEb4/N4YGbUhLkOvV6ct9mE8C4Twe7e', 'oui', '2023-09-11 08:26:24', '+50931030303', 'n/a', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=499;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
