param g;

param njeux;

param qttjeux {i in 1..njeux};

param v {i in 1..g, j in 1..njeux};

var x{i in 1..g,j in 1..njeux}, binary;


#Chaque jeu n'est disponible qu'en un seul exemplaire
s.t. un_seul_jeu {j in 1..njeux}: sum {i in 1..g} x[i,j] <= qttjeux[j];

#On fait en sorte que le plus grand nombre soit satisfait
#satisfy_everybody {i in 1..g}: sum {j in 1..njeux} x[i,j] >= 1;


#On ne peut recevoir un jeux qui n'a pas été demandé
s.t. get_only_wish {i in 1..g, j in 1..njeux} : x[i,j] <= v[i,j];


#s.t. un_seul_jeu_a_5 {i in 1..g} : sum {j in 1..njeux} (if x[i,j]==5 then 1 else 0) <=1; 


#satisfy_everybody2 {i in 1..g}: sum {j in 1..njeux} x[i,j] >= 1;



maximize f: sum {i in 1..g, j in 1..njeux} x[i,j]*v[i,j];




printf "---Resutat---\n";

solve;

printf "---Fin---\n";
for {i in 1..g} {
	for {j in 1..njeux} {
		printf " %d%d ",v[i,j],x[i,j];
	}
	printf "\n";
}

for {i in 1..g} {
	for {j in 1..njeux} {
		printf "@%d",x[i,j];
	}
}
printf "@";
end;