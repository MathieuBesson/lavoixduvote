<?php

namespace App\DataFixtures;

use App\Entity\Action;
use App\Entity\Candidate;
use App\Entity\Glossary;
use App\Entity\PoliticalParty;
use App\Entity\Primary;
use App\Entity\Program;
use App\Entity\Theme;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture {

    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager) {
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
                    $party->setName('PTT - Partie des travailleurs transfontaliers');
                    $party->setDescription('Parti qui défend les intérêts de tous les travailleurs transfontaliers, au Zimbabwe comme au Groënland');
                    $party->setSiteLink('www.ptt.ptt');
                    $candidate->setFirstName('Potato');
                    $candidate->setLastName('Duhamel');
                    $candidatPtt = $candidate;
                    break;
                case 1:
                    $party->setName('AST - Association des sauveurs de tam-tam');
                    $party->setDescription('Lutte contre toutes les discriminations faites aux joueurs de djembé, tambour, maracas');
                    $party->setSiteLink('www.ast.bzh');
                    $candidate->setFirstName('TamTam');
                    $candidate->setLastName('Tom');
                    $candidatAst = $candidate;

                    break;
                case 2:
                    $party->setName('Stupeflip Crou');
                    $party->setDescription('Association de stup fanatique');
                    $party->setSiteLink('www.stupefip.fr');
                    $candidate->setFirstName('King');
                    $candidate->setLastName('Ju');
                    $candidatStup = $candidate;
                    break;
            }
            $manager->persist($party);
            $manager->persist($candidate);
            $manager->persist($primary);
        }
        // Programs
        for ($i = 0 ; $i < 3 ; $i++) {
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
                    $program->setProgramLink('www.astprogram.ast');
                    $programAst = $program;
                    break;
                case 1:
                    $program->setCandidate($candidatPtt);
                    $program->setProgramLink('www.pttprogram.bzh');
                    $programPtt = $program;
                    break;
                case 2:
                    $program->setCandidate($candidatStup);
                    $program->setProgramLink('www.stupeflip.com');
                    $programStup = $program;
                    break;
            }
        }
        // Themes and Actions
        for ($i = 0; $i < 5; $i++) {
            $theme = new Theme();
            switch ($i) {
                case 0:
                    $theme->setLabel('Écologie');
                    for ($j = 0 ; $j < 3 ; $j++) {
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
                    for ($j = 0 ; $j < 3 ; $j++) {
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
                    for ($j = 0 ; $j < 3 ; $j++) {
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
                    for ($j = 0 ; $j < 3 ; $j++) {
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
                    for ($j = 0 ; $j < 3 ; $j++) {
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
                    $theme->setLabel('Défense');
                    for ($j = 0 ; $j < 3 ; $j++) {
                        $action = new Action();
                        $action->setTheme($theme);
                        switch ($j) {
                            case 0:
                                $action->setImportance(5);
                                $action->setTitle('Retour du service militaire');
                                $programStup->addAction($action);
                                break;
                            case 1:
                                $action->setImportance(2);
                                $action->setTitle('Sortie de l\'OTAN');
                                $programAst->addAction($action);
                                break;
                            case 2:
                                $action->setImportance(3);
                                $action->setTitle('Déclarer la guerre au Zimbabwe');
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
        for ($i = 0 ; $i < 5 ; $i++) {
            $glossary = new Glossary();
            $glossary->setDefinition(<<<EOT
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Illi enim inter se dissentiunt. Bestiarum vero nullum iudicium puto. Respondeat totidem verbis. Illum mallem levares, quo optimum atque humanissimum virum, Cn. Duo Reges: constructio interrete. </p>
<p>Conferam tecum, quam cuique verso rem subicias; Fortasse id optimum, sed ubi illud: Plus semper voluptatis? Quae sequuntur igitur? Ergo, inquit, tibi Q. Tu vero, inquam, ducas licet, si sequetur; Prave, nequiter, turpiter cenabat; </p>
<p>Tum Torquatus: Prorsus, inquit, assentior; Quae quidem vel cum periculo est quaerenda vobis; Honesta oratio, Socratica, Platonis etiam. Ut id aliis narrare gestiant? Occultum facinus esse potuerit, gaudebit; Istam voluptatem, inquit, Epicurus ignorat? </p>
<p>Sedulo, inquam, faciam. Age sane, inquam. Quis Aristidem non mortuum diligit? Erat enim Polemonis. </p>
<p>Quae ista amicitia est? Tamen a proposito, inquam, aberramus. Ut in geometria, prima si dederis, danda sunt omnia. Vide, quantum, inquam, fallare, Torquate. Duo enim genera quae erant, fecit tria. Quid vero? </p>
EOT
);
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
