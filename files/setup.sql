CREATE DATABASE `dannych_cse403` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `dannych_cse403`;

-- --------------------------------------------------------

--
-- Table structure for table `interviews`
--

CREATE TABLE IF NOT EXISTS `interviews` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `interviews`
--

INSERT INTO `interviews` (`id`, `title`) VALUES
(1, 'test interview 1');

-- --------------------------------------------------------

--
-- Table structure for table `participants`
--

CREATE TABLE IF NOT EXISTS `participants` (
  `interview_id` int(11) NOT NULL,
  `interviewer_id` int(11) NOT NULL,
  `interviewee_id` int(11) NOT NULL,
  PRIMARY KEY (`interview_id`),
  UNIQUE KEY `id` (`interview_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='This tables ';

--
-- Dumping data for table `participants`
--

INSERT INTO `participants` (`interview_id`, `interviewer_id`, `interviewee_id`) VALUES
(1, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE IF NOT EXISTS `schedules` (
  `interview_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_prepared` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`interview_id`, `date_created`, `date_prepared`) VALUES
(1, '2013-10-24 00:00:00', '2013-10-25 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `gender` varchar(1) NOT NULL,
  `email` text NOT NULL,
  `phone` int(11) NOT NULL DEFAULT '0',
  `affiliation` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `gender`, `email`, `phone`, `affiliation`) VALUES
(1, 'Danny Christanto', 'M', 'dannych@uw.edu', 0, 'Student'),
(2, 'Yosan Namara', 'M', 'ynamara@uw.edu', 0, 'Student'),
(3, 'Christopher Tjong', 'M', 'ctjong@uw.edu', 0, 'Students');

-- --------------------------------------------------------

--
-- Table structure for table `validations`
--

CREATE TABLE IF NOT EXISTS `validations` (
  `interview_id` int(11) NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `validations`
--

INSERT INTO `validations` (`interview_id`, `password`) VALUES
(1, 'q34tv6_4ysrtyasd234b456');


-- --------------------------------------------------------

--
-- Grant privileges
--

GRANT ALL ON dannych_cse403.* TO 'dannych'@'localhost';