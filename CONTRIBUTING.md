# Contribution Guideline

- install [make](https://man7.org/linux/man-pages/man1/make.1.html)
- [fork this repository]((https://github.com/setnemo/asterisk-notation/fork))
- clone you fork
- create new feature/fix branch, name like fix_bug_bla_bla or feature_bla_bla_bla
- install composer dependencies `composer install`
- write code according PSR-12 Standard and don't forget about unit tests
- check PSR with command `make psr12-check` and fix it with command `make psr12-fix`
- check with command `make psalm` and if you have errors - fix it
- commit you work, also write commit message according [Conventional Commits](https://www.conventionalcommits.org/en/v1.0.0/)
- push you work and create pull request
- 