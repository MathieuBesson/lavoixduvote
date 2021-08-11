<?php

namespace App\DataFixtures;

use App\Entity\Action;
use App\Entity\Candidate;
use App\Entity\Glossary;
use App\Entity\GlossaryCategory;
use App\Entity\PoliticalParty;
use App\Entity\Primary;
use App\Entity\Program;
use App\Entity\StarMeasure;
use App\Entity\Theme;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        // Political Party, primary and candidates
        for ($i = 0; $i < 3; $i++) {
            $party = new PoliticalParty();
            $candidate = new Candidate();
            $primary = new Primary();
            $candidate->setElectedByPrimary(false);
            $candidate->setSecondRoundElections(false);
            $candidate->setBiography(<<<EOT
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Minime vero, inquit ille, consentit. Qua tu etiam inprudens utebare non numquam. Nulla erit controversia. Duo Reges: constructio interrete. Omnia contraria, quos etiam insanos esse vultis. Ut pulsi recurrant? </p>
<p>Hoc loco tenere se Triarius non potuit. Vestri haec verecundius, illi fortasse constantius. Age, inquies, ista parva sunt. An hoc usque quaque, aliter in vita? Quid enim est a Chrysippo praetermissum in Stoicis? Quaerimus enim finem bonorum. </p>
<p>Tubulo putas dicere? Collatio igitur ista te nihil iuvat. Est, ut dicis, inquit; Virtutis, magnitudinis animi, patientiae, fortitudinis fomentis dolor mitigari solet. Hoc loco tenere se Triarius non potuit. Qui ita affectus, beatum esse numquam probabis; Sed fortuna fortis; </p>
<p>Quid sequatur, quid repugnet, vident. At certe gravius. Sed in rebus apertissimis nimium longi sumus. Immo videri fortasse. Quis enim redargueret? Non semper, inquam; Omnia contraria, quos etiam insanos esse vultis. Vide, quantum, inquam, fallare, Torquate. </p>
<p>Duarum enim vitarum nobis erunt instituta capienda. Nonne igitur tibi videntur, inquit, mala? Quare attende, quaeso. </p>
EOT
            );
            $party->setPicture('fixture.png');
            $candidate->setPicture('fixture.jpg');
            $primary->setDateFirstRound(new \DateTime('+3 months'));
            $primary->setDateSecondRound(new \DateTime('+4 months'));
            $candidate->setPoliticalParty($party);
            $primary->setPoliticalParty($party);
            switch ($i) {
                case 0:
                    $party->setName('Parti des travailleurs transfontaliers');
                    $party->setAcronym('PTT');
                    $party->setDescription('Parti qui défend les intérêts de tous les travailleurs transfontaliers, au Zimbabwe comme au Groënland');
                    $party->setSiteLink('https://www.ptt.ptt');
                    $party->setMail('ptt@ptt.ptt');
                    $party->setAdress('213 rue des PTT 93000 PTT');
                    $candidate->setFirstName('Potato');
                    $candidate->setLastName('Duhamel');
                    $candidatPtt = $candidate;
                    break;
                case 1:
                    $party->setName('Association des sauveurs de tam-tam');
                    $party->setAcronym('AST');
                    $party->setDescription('Lutte contre toutes les discriminations faites aux joueurs de djembé, tambour, maracas');
                    $party->setSiteLink('https://www.ast.bzh');
                    $party->setMail('ast@ast.ast');
                    $party->setAdress('213 rue des AST 93000 AST');
                    $candidate->setFirstName('TamTam');
                    $candidate->setLastName('Tom');
                    $candidatAst = $candidate;
                    break;
                case 2:
                    $party->setName('Stupeflip Crou');
                    $party->setAcronym('LECROU');
                    $party->setDescription('Association de stup fanatique');
                    $party->setSiteLink('https://www.stupefip.fr');
                    $party->setMail('stup@stupeflip.fr');
                    $party->setAdress('Région sud');
                    $candidate->setFirstName('King');
                    $candidate->setLastName('Ju');
                    $candidatStup = $candidate;
                    break;
            }
            $manager->persist($party);
            $manager->persist($primary);
        }
        // StarMeasure
        for ($i = 0; $i < 3; $i++) {
            $measures = [
                'Santé'              => 'icon-lvdv-heart-white',
                'Sécurité'           => 'icon-lvdv-shield-white',
                'Économie'           => 'icon-lvdv-economy-white',
                'Écologie'           => 'icon-lvdv-environment-white',
                'Immigration'        => 'icon-lvdv-immigrations-white',
                'Éducation'          => 'icon-lvdv-education',
                'Culture'            => 'icon-lvdv-culture-white',
                'Protection Sociale' => 'icon-lvdv-social-protection-white',
                'Innovation'         => 'icon-lvdv-innovations-white',
                'Emploi'             => 'icon-lvdv-employment-white',
            ];

            for ($j = 0; $j < 3; $j++) {
                $starMeasure = new StarMeasure();
                $starMeasure->setTitle(array_rand($measures, 1));
                $starMeasure->setIcon($measures[$starMeasure->getTitle()]);

                switch ($j) {
                    case 0:
                        $starMeasure->setDescription(<<<EOT
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Unum est sine dolore esse, alterum cum voluptate. Audeo dicere, inquit. Hoc sic expositum dissimile est superiori. Omnes enim iucundum motum, quo sensus hilaretur. </p>
<p>Explanetur igitur. Igitur ne dolorem quidem. Tamen a proposito, inquam, aberramus. Et nemo nimium beatus est; Quid est igitur, inquit, quod requiras? </p>
<p>Honesta oratio, Socratica, Platonis etiam. Duo Reges: constructio interrete. Quo igitur, inquit, modo? Est, ut dicis, inquam. Restatis igitur vos; Multoque hoc melius nos veriusque quam Stoici. Et quod est munus, quod opus sapientiae? </p>
EOT
                        );
                        break;
                    case 1:
                        $starMeasure->setDescription(<<<EOT
<p>Honesta oratio, Socratica, Platonis etiam. Duo Reges: constructio interrete. Quo igitur, inquit, modo? Est, ut dicis, inquam. Restatis igitur vos; Multoque hoc melius nos veriusque quam Stoici. Et quod est munus, quod opus sapientiae? </p>
<p>Explanetur igitur. Igitur ne dolorem quidem. Tamen a proposito, inquam, aberramus. Et nemo nimium beatus est; Quid est igitur, inquit, quod requiras? </p>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Unum est sine dolore esse, alterum cum voluptate. Audeo dicere, inquit. Hoc sic expositum dissimile est superiori. Omnes enim iucundum motum, quo sensus hilaretur. </p>
EOT
                        );
                        break;
                    case 2:
                        $starMeasure->setDescription(<<<EOT
<p>Honesta oratio, Socratica, Platonis etiam. Duo Reges: constructio interrete. Quo igitur, inquit, modo? Est, ut dicis, inquam. Restatis igitur vos; Multoque hoc melius nos veriusque quam Stoici. Et quod est munus, quod opus sapientiae? </p>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Unum est sine dolore esse, alterum cum voluptate. Audeo dicere, inquit. Hoc sic expositum dissimile est superiori. Omnes enim iucundum motum, quo sensus hilaretur. </p>
<p>Explanetur igitur. Igitur ne dolorem quidem. Tamen a proposito, inquam, aberramus. Et nemo nimium beatus est; Quid est igitur, inquit, quod requiras? </p>
EOT
                        );
                        break;
                }

                switch ($i) {
                    case 0:
                        $starMeasure->setCandidate($candidatAst);
                        $candidatAst->addStarMeasure($starMeasure);
                        break;
                    case 1:
                        $starMeasure->setCandidate($candidatPtt);
                        $candidatPtt->addStarMeasure($starMeasure);
                        break;
                    case 2:
                        $starMeasure->setCandidate($candidatStup);
                        $candidatStup->addStarMeasure($starMeasure);
                        break;
                }
                $manager->persist($starMeasure);
            }
        }
        $manager->persist($candidatAst);
        $manager->persist($candidatPtt);
        $manager->persist($candidatStup);

        // Programs
        for ($i = 0; $i < 3; $i++) {
            $program = new Program();
            $program->setPresentation(<<<EOT
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Unum est sine dolore esse, alterum cum voluptate. Audeo dicere, inquit. Hoc sic expositum dissimile est superiori. Omnes enim iucundum motum, quo sensus hilaretur. </p>
<p>Honesta oratio, Socratica, Platonis etiam. Duo Reges: constructio interrete. Quo igitur, inquit, modo? Est, ut dicis, inquam. Restatis igitur vos; Multoque hoc melius nos veriusque quam Stoici. Et quod est munus, quod opus sapientiae? </p>
<p>Explanetur igitur. Igitur ne dolorem quidem. Tamen a proposito, inquam, aberramus. Et nemo nimium beatus est; Quid est igitur, inquit, quod requiras? </p>
<p>Murenam te accusante defenderem. Paria sunt igitur. Prioris generis est docilitas, memoria; Sine ea igitur iucunde negat posse se vivere? Bonum liberi: misera orbitas. Summum ením bonum exposuit vacuitatem doloris; </p>
<p>Post enim Chrysippum eum non sane est disputatum. Utilitatis causa amicitia est quaesita. Quid autem habent admirationis, cum prope accesseris? Omnia peccata paria dicitis. Videamus animi partes, quarum est conspectus illustrior; </p>
EOT
            );
            switch ($i) {
                case 0:
                    $program->setCandidate($candidatAst);
                    $program->setProgramLink('https://www.astprogram.ast');
                    $programAst = $program;
                    break;
                case 1:
                    $program->setCandidate($candidatPtt);
                    $program->setProgramLink('https://www.pttprogram.bzh');
                    $programPtt = $program;
                    break;
                case 2:
                    $program->setCandidate($candidatStup);
                    $program->setProgramLink('https://www.stupeflip.com');
                    $programStup = $program;
                    break;
            }
        }
        // Themes and Actions
        for ($i = 0; $i <= 9; $i++) {
            $theme = new Theme();
            switch ($i) {
                case 0:
                    $theme->setLabel('Écologie');
                    for ($j = 0; $j < 3; $j++) {
                        $action = new Action();
                        $action->setTheme($theme);
                        switch ($j) {
                            case 0:
                                $action->setImportance(5);
                                $action->setTitle('Sortie du nucléaire en 2050');
                                $programStup->addAction($action);
                                $programPtt->addAction($action);
                                $programAst->addAction($action);
                                break;
                            case 1:
                                $action->setImportance(2);
                                $action->setTitle('Recyclage obligatoire');
                                $programStup->addAction($action);
                                $programAst->addAction($action);
                                break;
                            case 2:
                                $action->setImportance(3);
                                $action->setTitle('Interdiction du gasoil');
                                $programAst->addAction($action);
                                break;
                        }
                        $manager->persist($action);
                    }
                    break;
                case 1:
                    $theme->setLabel('Santé');
                    for ($j = 0; $j < 3; $j++) {
                        $action = new Action();
                        $action->setTheme($theme);
                        switch ($j) {
                            case 0:
                                $action->setImportance(5);
                                $action->setTitle('Nationalisation des hôpitaux');
                                $programAst->addAction($action);
                                break;
                            case 1:
                                $action->setImportance(2);
                                $action->setTitle('Mutation des médecins pour lutter contre les déserts médicaux');
                                $programStup->addAction($action);
                                $programAst->addAction($action);
                                break;
                            case 2:
                                $action->setImportance(3);
                                $action->setTitle('Augmentation des salaires du personnel hospitalier');
                                $programPtt->addAction($action);
                                break;
                        }
                        $manager->persist($action);
                    }
                    break;
                case 2:
                    $theme->setLabel('Économie');
                    for ($j = 0; $j < 3; $j++) {
                        $action = new Action();
                        $action->setTheme($theme);
                        switch ($j) {
                            case 0:
                                $action->setImportance(5);
                                $action->setTitle('Augmentation du SMIC');
                                $programStup->addAction($action);
                                $programAst->addAction($action);
                                break;
                            case 1:
                                $action->setImportance(2);
                                $action->setTitle('Suppression du RSA');
                                $programPtt->addAction($action);
                                break;
                            case 2:
                                $action->setImportance(3);
                                $action->setTitle('Augmentation des impôts');
                                $programStup->addAction($action);
                                break;
                        }
                        $manager->persist($action);
                    }
                    break;
                case 3:
                    $theme->setLabel('Sécurité');
                    for ($j = 0; $j < 3; $j++) {
                        $action = new Action();
                        $action->setTheme($theme);
                        switch ($j) {
                            case 0:
                                $action->setImportance(5);
                                $action->setTitle('Recrutement de 20 000 policiers supplémentaires');
                                $programStup->addAction($action);
                                break;
                            case 1:
                                $action->setImportance(2);
                                $action->setTitle('Retour de la double peine');
                                $programAst->addAction($action);
                                break;
                            case 2:
                                $action->setImportance(3);
                                $action->setTitle('Policiers dans les écoles');
                                $programPtt->addAction($action);
                                break;
                        }
                        $manager->persist($action);
                    }
                    break;
                case 4:
                    $theme->setLabel('Emploi');
                    for ($j = 0; $j < 3; $j++) {
                        $action = new Action();
                        $action->setTheme($theme);
                        switch ($j) {
                            case 0:
                                $action->setImportance(5);
                                $action->setTitle('Suppression de la Loi Travail');
                                $programStup->addAction($action);
                                $programPtt->addAction($action);
                                $programAst->addAction($action);
                                break;
                            case 1:
                                $action->setImportance(2);
                                $action->setTitle('Recrutement de 30 000 fonctionnaires');
                                $programStup->addAction($action);
                                break;
                            case 2:
                                $action->setImportance(3);
                                $action->setTitle('Suppression de 100 000 fonctionnaires');
                                $programAst->addAction($action);
                                break;
                        }
                        $manager->persist($action);
                    }
                    break;
                case 5:
                    $theme->setLabel('Protection sociale');
                    for ($j = 0; $j < 3; $j++) {
                        $action = new Action();
                        $action->setTheme($theme);
                        switch ($j) {
                            case 0:
                                $action->setImportance(5);
                                $action->setTitle('Création d\'un système de mère au foyer à partir de 12 enfants');
                                $programStup->addAction($action);
                                break;
                            case 1:
                                $action->setImportance(2);
                                $action->setTitle('Supprimer le bouclier fiscal');
                                $programAst->addAction($action);
                                break;
                            case 2:
                                $action->setImportance(3);
                                $action->setTitle('Création d\'un revenu universel');
                                $programPtt->addAction($action);
                                break;
                        }
                        $manager->persist($action);
                    }
                    break;
                case 6:
                    $theme->setLabel('Immigration');
                    for ($j = 0; $j < 3; $j++) {
                        $action = new Action();
                        $action->setTheme($theme);
                        switch ($j) {
                            case 0:
                                $action->setImportance(5);
                                $action->setTitle('Régularisation de tous les sans-papiers');
                                $programStup->addAction($action);
                                break;
                            case 1:
                                $action->setImportance(2);
                                $action->setTitle('Expulsion de tous les sans-papiers');
                                $programAst->addAction($action);
                                break;
                            case 2:
                                $action->setImportance(3);
                                $action->setTitle('Suppression du rassemblement familial');
                                $programPtt->addAction($action);
                                break;
                        }
                        $manager->persist($action);
                    }
                    break;
                case 7:
                    $theme->setLabel('Culture');
                    for ($j = 0; $j < 3; $j++) {
                        $action = new Action();
                        $action->setTheme($theme);
                        switch ($j) {
                            case 0:
                                $action->setImportance(5);
                                $action->setTitle('Pass Culture monté à 10000000€');
                                $programStup->addAction($action);
                                break;
                            case 1:
                                $action->setImportance(2);
                                $action->setTitle('Subvention pour les artistes');
                                $programAst->addAction($action);
                                break;
                            case 2:
                                $action->setImportance(3);
                                $action->setTitle('Brûler tous les livres');
                                $programPtt->addAction($action);
                                break;
                        }
                        $manager->persist($action);
                    }
                    break;
                case 8:
                    $theme->setLabel('Innovation');
                    for ($j = 0; $j < 3; $j++) {
                        $action = new Action();
                        $action->setTheme($theme);
                        switch ($j) {
                            case 0:
                                $action->setImportance(5);
                                $action->setTitle('On va sur la Lune !');
                                $programStup->addAction($action);
                                break;
                            case 1:
                                $action->setImportance(2);
                                $action->setTitle('Budget de 1 000 000 000 € pour la recherche');
                                $programAst->addAction($action);
                                break;
                            case 2:
                                $action->setImportance(3);
                                $action->setTitle('On reprend la recherche sur les cellules souches');
                                $programPtt->addAction($action);
                                break;
                        }
                        $manager->persist($action);
                    }
                    break;
                case 9:
                    $theme->setLabel('Éducation');
                    for ($j = 0; $j < 3; $j++) {
                        $action = new Action();
                        $action->setTheme($theme);
                        switch ($j) {
                            case 0:
                                $action->setImportance(5);
                                $action->setTitle('Suppression du bac');
                                $programStup->addAction($action);
                                break;
                            case 1:
                                $action->setImportance(2);
                                $action->setTitle('Recrutement de 50 000 profs');
                                $programAst->addAction($action);
                                break;
                            case 2:
                                $action->setImportance(3);
                                $action->setTitle('Suppression des prépas');
                                $programPtt->addAction($action);
                                break;
                        }
                        $manager->persist($action);
                    }
                    break;
            }
            $manager->persist($theme);
        }
        $manager->persist($programPtt);
        $manager->persist($programAst);
        $manager->persist($programStup);
        // Glossary
        // Category
        for ($i = 0; $i < 3; $i++) {
            $glossaryCategory = new GlossaryCategory();
            switch ($i) {
                case 0:
                    $glossaryCategory->setLabel('Textes de loi');
                    break;
                case 1:
                    $glossaryCategory->setLabel('Évènements');
                    break;
                case 2:
                    $glossaryCategory->setLabel('Jargon politique');
                    break;
            }

            $manager->persist($glossaryCategory);
        }

        for ($i = 0; $i < 5; $i++) {
            $glossary = new Glossary();
            $glossary->setDefinition(<<<EOT
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Illi enim inter se dissentiunt. Bestiarum vero nullum iudicium puto. Respondeat totidem verbis. Illum mallem levares, quo optimum atque humanissimum virum, Cn. Duo Reges: constructio interrete. </p>
<p>Conferam tecum, quam cuique verso rem subicias; Fortasse id optimum, sed ubi illud: Plus semper voluptatis? Quae sequuntur igitur? Ergo, inquit, tibi Q. Tu vero, inquam, ducas licet, si sequetur; Prave, nequiter, turpiter cenabat; </p>
<p>Tum Torquatus: Prorsus, inquit, assentior; Quae quidem vel cum periculo est quaerenda vobis; Honesta oratio, Socratica, Platonis etiam. Ut id aliis narrare gestiant? Occultum facinus esse potuerit, gaudebit; Istam voluptatem, inquit, Epicurus ignorat? </p>
<p>Sedulo, inquam, faciam. Age sane, inquam. Quis Aristidem non mortuum diligit? Erat enim Polemonis. </p>
<p>Quae ista amicitia est? Tamen a proposito, inquam, aberramus. Ut in geometria, prima si dederis, danda sunt omnia. Vide, quantum, inquam, fallare, Torquate. Duo enim genera quae erant, fecit tria. Quid vero? </p>
EOT
            );
            $glossary->setCategory($glossaryCategory);
            switch ($i) {
                case 0:
                    $glossary->setWord('Lorem');
                    break;
                case 1:
                    $glossary->setWord('Ipsum');
                    break;
                case 2:
                    $glossary->setWord('Dolor');
                    break;
                case 3:
                    $glossary->setWord('Aristidem');
                    break;
                case 4:
                    $glossary->setWord('Platonis');
                    break;
            }
            $manager->persist($glossary);
        }
        $user = new User();
        $user->setUsername('admin');
        $user->setPassword($this->passwordHasher->hashPassword($user, '1231'));
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);

        $manager->flush();
    }
}
